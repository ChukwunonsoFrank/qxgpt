<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Kyc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PrivateFileController extends Controller
{
    public function show($path)
    {
        if (! auth()->check()) {
            abort(403);
        }

        // Decode the URL-encoded path
        $path = urldecode($path);

        if (Str::contains($path, ['..', '\\'])) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $user = auth()->user();
        if (! $user->is_admin && ! $this->belongsToAuthenticatedUser($path)) {
            abort(403);
        }

        return Storage::disk('local')->response($path);
    }

    private function belongsToAuthenticatedUser(string $path): bool
    {
        return Kyc::where('id_image_path', $path)
            ->where('user_id', auth()->id())
            ->exists()
            || Deposit::where('payment_screenshot_path', $path)
                ->where('user_id', auth()->id())
                ->exists();
    }
}
