<?php

use App\Livewire\Admin\AdminKyc;
use App\Models\Kyc;
use App\Models\User;
use App\Notifications\KYCApproved;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('auto approves only the current page and skips notifications for already approved requests', function () {
    Notification::fake();

    $this->actingAs(makeAdminKycUser([
        'is_admin' => true,
        'referral_code' => 'ADMIN-KYC-1001',
    ]));

    $secondPageUser = makeAdminKycUser([
        'email' => 'page-two@example.com',
        'referral_code' => 'REF-PAGE-0001',
    ]);

    $secondPageKyc = createAdminKycRecord(
        user: $secondPageUser,
        fullname: 'Second Page User',
        status: 'pending',
        path: 'kyc/page-two.jpg',
        createdAt: now()->subMinutes(11),
    );

    $visiblePendingRequests = collect(range(1, 9))->map(function (int $index): Kyc {
        $user = makeAdminKycUser([
            'email' => "visible-pending-{$index}@example.com",
            'referral_code' => "REF-VISIBLE-{$index}",
        ]);

        return createAdminKycRecord(
            user: $user,
            fullname: "Visible Pending {$index}",
            status: 'pending',
            path: "kyc/visible-pending-{$index}.jpg",
            createdAt: now()->subMinutes(10 - $index),
        );
    });

    $alreadyApprovedUser = makeAdminKycUser([
        'email' => 'already-approved@example.com',
        'referral_code' => 'REF-APPROVED-0001',
        'is_kyc_verified' => true,
    ]);

    $alreadyApprovedKyc = createAdminKycRecord(
        user: $alreadyApprovedUser,
        fullname: 'Already Approved User',
        status: 'approved',
        path: 'kyc/already-approved.jpg',
        createdAt: now(),
    );

    Livewire::test(AdminKyc::class)
        ->assertSee('Auto Approve')
        ->call('approveCurrentPage')
        ->assertHasNoErrors();

    $visiblePendingRequests->each(function (Kyc $kyc): void {
        expect($kyc->fresh()->status)->toBe('approved');
        expect($kyc->user->fresh()->is_kyc_verified)->toBe(1);
        Notification::assertSentTo($kyc->user, KYCApproved::class);
    });

    expect($alreadyApprovedKyc->fresh()->status)->toBe('approved');
    expect($alreadyApprovedUser->fresh()->is_kyc_verified)->toBe(1);
    Notification::assertNotSentTo($alreadyApprovedUser, KYCApproved::class);

    expect($secondPageKyc->fresh()->status)->toBe('pending');
    expect($secondPageUser->fresh()->is_kyc_verified)->toBe(0);
    Notification::assertNotSentTo($secondPageUser, KYCApproved::class);

    Notification::assertCount(9);
});

it('approves all pending kyc requests and verifies their users', function () {
    Notification::fake();

    $this->actingAs(makeAdminKycUser([
        'is_admin' => true,
        'referral_code' => 'ADMIN-KYC-1002',
    ]));

    $pendingRequests = collect(range(1, 12))->map(function (int $index): Kyc {
        $user = makeAdminKycUser([
            'email' => "pending-all-{$index}@example.com",
            'referral_code' => "REF-ALL-{$index}",
        ]);

        return createAdminKycRecord(
            user: $user,
            fullname: "Pending All {$index}",
            status: 'pending',
            path: "kyc/pending-all-{$index}.jpg",
            createdAt: now()->subMinutes($index),
        );
    });

    $approvedUser = makeAdminKycUser([
        'email' => 'already-approved-all@example.com',
        'referral_code' => 'REF-APPROVED-ALL',
        'is_kyc_verified' => true,
    ]);

    $approvedKyc = createAdminKycRecord(
        user: $approvedUser,
        fullname: 'Already Approved All',
        status: 'approved',
        path: 'kyc/already-approved-all.jpg',
        createdAt: now(),
    );

    $declinedUser = makeAdminKycUser([
        'email' => 'declined-all@example.com',
        'referral_code' => 'REF-DECLINED-ALL',
    ]);

    $declinedKyc = createAdminKycRecord(
        user: $declinedUser,
        fullname: 'Declined All',
        status: 'declined',
        path: 'kyc/declined-all.jpg',
        createdAt: now(),
    );

    Livewire::test(AdminKyc::class)
        ->assertSee('Approve All KYC')
        ->assertSee('wire:confirm="Approve all pending KYC requests?"', false)
        ->call('approveAllPending')
        ->assertSee('12 pending KYC requests approved successfully.')
        ->assertHasNoErrors();

    $pendingRequests->each(function (Kyc $kyc): void {
        expect($kyc->fresh()->status)->toBe('approved');
        expect($kyc->user->fresh()->is_kyc_verified)->toBe(1);
        Notification::assertSentTo($kyc->user, KYCApproved::class);
    });

    expect($approvedKyc->fresh()->status)->toBe('approved');
    expect($approvedUser->fresh()->is_kyc_verified)->toBe(1);
    Notification::assertNotSentTo($approvedUser, KYCApproved::class);

    expect($declinedKyc->fresh()->status)->toBe('declined');
    expect($declinedUser->fresh()->is_kyc_verified)->toBe(0);
    Notification::assertNotSentTo($declinedUser, KYCApproved::class);

    Notification::assertCount(12);
});

function makeAdminKycUser(array $attributes = []): User
{
    return User::unguarded(function () use ($attributes): User {
        return User::factory()->create(array_merge([
            'uid' => fake()->unique()->numerify('##########'),
            'unhashed_password' => 'password',
            'referral_code' => fake()->unique()->bothify('REF-####'),
            'referred_by' => null,
            'live_balance' => 0,
            'demo_balance' => 1_000_000,
            'account_status' => 'active',
            'country' => 'NG',
            'is_admin' => false,
            'is_banned' => false,
            'is_kyc_verified' => false,
        ], $attributes));
    });
}

function createAdminKycRecord(
    User $user,
    string $fullname,
    string $status,
    string $path,
    DateTimeInterface $createdAt,
): Kyc {
    $kyc = Kyc::create([
        'user_id' => $user->id,
        'fullname' => $fullname,
        'country' => 'Nigeria',
        'dob' => '1990-01-01',
        'id_image_path' => $path,
        'status' => $status,
    ]);

    $kyc->forceFill([
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ])->saveQuietly();

    return $kyc->fresh();
}
