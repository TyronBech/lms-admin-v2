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
        Log::info('[Auth][Logout] Logout completed successfully', [
            'user_id' => null,
            'ip' => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        return $request->wantsJson()
          ? response()->noContent()
          : redirect()->route('home');
    }
}
