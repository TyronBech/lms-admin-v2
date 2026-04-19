<?php

namespace App\Http\Responses\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
    /**
     * Create a logout response.
     */
    public function toResponse($request): RedirectResponse|JsonResponse
    {
        $userId = $request->user()?->id ?? $request->session()->get('auth_user_id');

        Log::info('[Auth][Logout] Logout completed successfully', [
            'user_id' => $userId,
            'ip' => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        return $request->wantsJson()
          ? response()->noContent()
          : redirect()->route('home');
    }
}
