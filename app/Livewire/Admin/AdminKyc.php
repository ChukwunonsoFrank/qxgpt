<?php

namespace App\Livewire\Admin;

use App\Models\Kyc;
use App\Models\User;
use App\Notifications\KYCApproved;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]

class AdminKyc extends Component
{
    use WithPagination;

    public function getStatusIndicatorColor(string $status): string
    {
        if ($status === 'pending') {
            return 'bg-warning-50 text-warning-600';
        }

        if ($status === 'approved') {
            return 'bg-success-50 text-success-600';
        }

        if ($status === 'declined') {
            return 'bg-error-50 text-error-600';
        }

        return 'bg-gray-100 text-gray-600';
    }

    public function approveCurrentPage(): void
    {
        try {
            $currentPageRequests = $this->kycRequestsQuery()
                ->paginate(10, ['*'], 'page', $this->getPage())
                ->getCollection();

            $approvableRequests = $currentPageRequests
                ->filter(fn (Kyc $kyc): bool => $kyc->status !== 'approved' && $kyc->user !== null)
                ->values();

            if ($approvableRequests->isEmpty()) {
                session()->flash('success-message', 'No KYC requests on this page needed approval.');

                return;
            }

            $approvableUserIds = $approvableRequests->pluck('user_id')->unique()->all();
            $approvableKycIds = $approvableRequests->pluck('id')->all();

            DB::transaction(function () use ($approvableUserIds, $approvableKycIds): void {
                User::query()->whereIn('id', $approvableUserIds)->update([
                    'is_kyc_verified' => true,
                ]);

                Kyc::query()->whereIn('id', $approvableKycIds)->update([
                    'status' => 'approved',
                ]);
            });

            $approvableRequests->each(function (Kyc $kyc): void {
                $kyc->user?->notify(new KYCApproved($kyc->user->name));
            });

            $approvedCount = count($approvableKycIds);

            session()->flash(
                'success-message',
                "{$approvedCount} KYC request".($approvedCount === 1 ? '' : 's').' approved successfully.',
            );
        } catch (\Exception $exception) {
            session()->flash('error-message', $exception->getMessage());
        }
    }

    public function approveAllPending(): void
    {
        $approvedCount = 0;

        try {
            Kyc::query()
                ->where('status', 'pending')
                ->whereHas('user', function (Builder $query): void {
                    $query->where('is_admin', 0);
                })
                ->chunkById(100, function ($kycRequests) use (&$approvedCount): void {
                    foreach ($kycRequests as $kycRequest) {
                        $approvedUser = DB::transaction(function () use ($kycRequest): ?User {
                            $lockedKyc = Kyc::query()
                                ->lockForUpdate()
                                ->find($kycRequest->id);

                            if (! $lockedKyc instanceof Kyc || $lockedKyc->status !== 'pending') {
                                return null;
                            }

                            $user = User::query()
                                ->lockForUpdate()
                                ->find($lockedKyc->user_id);

                            if (! $user instanceof User || $user->is_admin) {
                                return null;
                            }

                            $user->is_kyc_verified = true;
                            $user->save();

                            $lockedKyc->status = 'approved';
                            $lockedKyc->save();

                            return $user;
                        });

                        if ($approvedUser instanceof User) {
                            $approvedUser->notify(new KYCApproved($approvedUser->name));
                            $approvedCount++;
                        }
                    }
                });

            $this->resetPage();

            session()->flash(
                'success-message',
                "{$approvedCount} pending KYC request".($approvedCount === 1 ? '' : 's').' approved successfully.',
            );
        } catch (\Exception $exception) {
            session()->flash('error-message', $exception->getMessage());
        }
    }

    public function render(): View
    {
        $kycRequests = $this->kycRequestsQuery()->paginate(10);

        return view('livewire.admin.admin-kyc', [
            'kycRequests' => $kycRequests,
        ]);
    }

    private function kycRequestsQuery(): Builder
    {
        return Kyc::query()
            ->with('user')
            ->whereHas('user', function (Builder $query): void {
                $query->where('is_admin', 0);
            })
            ->latest();
    }
}
