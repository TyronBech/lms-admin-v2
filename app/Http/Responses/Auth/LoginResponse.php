<?php

namespace App\Http\Responses\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an authentication response.
     */
    public function toResponse($request): RedirectResponse|JsonResponse
    {
        $userId = Auth::id();

        if (! $userId) {
            Log::warning('[Auth][Login] Login response reached without authenticated user', [
                'user_id' => null,
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return redirect()->route('login');
        }

        $request->session()->put('login_source', 'Admin');
        $request->session()->save();

        if (config('session.driver') === 'database') {
            $sessionConnection = DB::connection(config('session.connection') ?: config('database.default'));

            $sessionConnection->beginTransaction();

            try {
                $sessionConnection->statement('SET @current_user_id = ?', [$userId]);

                $sessionConnection->table(config('session.table', 'sessions'))
                    ->where('id', $request->session()->getId())
                    ->update(['login_source' => 'Admin']);

                $sessionConnection->commit();
            } catch (\Throwable $e) {
                $sessionConnection->rollBack();

                Log::error('[Auth][Login] Failed to persist login source', [
                    'user_id' => $userId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'ip' => $request->ip(),
                    'timestamp' => now()->toDateTimeString(),
                ]);
            }
        }

        Log::info('[Auth][Login] Login completed successfully', [
            'user_id' => $userId,
            'session_id' => $request->session()->getId(),
            'ip' => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        return $request->wantsJson()
          ? response()->noContent()
          : redirect()->intended(config('fortify.home'));
    }
}
