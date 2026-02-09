<?php

namespace App\Livewire\Dashboard;

use App\Models\Kyc;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout("components.layouts.app")]
class Account extends Component
{
    use WithFileUploads;

    public string $kycStatus = "";

    public bool $isKycPending = false;

    public $profilePicture;

    protected $rules = [
        "profilePicture" => "required|file|mimes:jpeg,jpg,png|max:5120",
    ];

    protected $messages = [
        "profilePicture.required" => "Please upload your profile picture.",
        "profilePicture.file" => "The uploaded file is not valid.",
        "profilePicture.mimes" =>
            "Profile picture must be a JPEG, JPG or PNG file.",
        "profilePicture.max" => "Profile picture size cannot exceed 5MB.",
    ];

    public function mount()
    {
        $this->kycStatus = auth()->user()->is_kyc_verified
            ? "Verified"
            : "Not verified";
        $kycRequest = Kyc::where("user_id", "=", auth()->user()->id, "and")
            ->latest()
            ->first();

        if ($kycRequest && $kycRequest["status"] === "pending") {
            $this->isKycPending = true;
        }
    }

    public function saveProfilePicture()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $this->dispatch(
                "error-message",
                message: implode(" ", $errors),
            )->self();
            return;
        }

        try {
            $user = Auth::user();
            $user->profile_image_path =
                "profile-picture/" .
                $this->profilePicture->getClientOriginalName();
            $user->save();

            $this->profilePicture->storeAs(
                "profile-picture",
                $this->profilePicture->getClientOriginalName(),
                "public",
            );

            $this->dispatch(
                "success-message",
                message: "Profile picture updated",
            )->self();
        } catch (\Exception $e) {
            $this->dispatch("error-message", message: $e->getMessage())->self();
        }
    }

    public function getStatusIndicatorColor(string $status)
    {
        if ($status === "pending") {
            return "bg-yellow-600";
        }

        if ($status === "approved") {
            return "bg-[#31865b]";
        }

        if ($status === "declined") {
            return "bg-[#e32d2d]";
        }
    }

    public function render()
    {
        return view("livewire.dashboard.account");
    }
}
