<?php

namespace App\Services\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminAuthenticationService
{
    /**
     * Attempt to authenticate an admin user for Fortify.
     */
    public function authenticate(Request $request): ?Authenticatable
    {
        $email = Str::lower(trim((string) $request->input('email')));
        $request->merge(['email' => $email]);

        Log::info('[Auth][Login] Authentication attempt initiated', [
            'user_id' => null,
            'email_hash' => $this->emailHash($email),
            'ip' => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        $user = $this->findUserByEmail($email);

        if (! $user instanceof Model || ! $user instanceof Authenticatable) {
            Log::warning('[Auth][Login] Authentication failed: user not found', [
                'user_id' => null,
                'email_hash' => $this->emailHash($email),
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return null;
        }

        if (! Hash::check((string) $request->input('password'), (string) $user->getAuthPassword())) {
            Log::warning('[Auth][Login] Authentication failed: invalid password', [
                'user_id' => $user->getAuthIdentifier(),
                'email_hash' => $this->emailHash($email),
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return null;
        }

        if (! method_exists($user, 'getRoleNames') || $user->getRoleNames()->isEmpty()) {
            Log::warning('[Auth][Login] Authentication failed: missing role assignment', [
                'user_id' => $user->getAuthIdentifier(),
                'email_hash' => $this->emailHash($email),
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return null;
        }

        Log::info('[Auth][Login] Credentials validated successfully', [
            'user_id' => $user->getAuthIdentifier(),
            'ip' => $request->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        return $user;
    }

    /**
     * Resolve the configured auth model and find a user by email.
     */
    private function findUserByEmail(string $email): ?Model
    {
        $modelClass = config('auth.providers.users.model');

        if (! is_string($modelClass) || ! class_exists($modelClass) || ! is_subclass_of($modelClass, Model::class)) {
            return null;
        }

        /** @var class-string<Model> $modelClass */
        return $modelClass::query()
            ->where('email', $email)
            ->first();
    }

    /**
     * Hash an email address for safe, non-PII log context.
     */
    private function emailHash(string $email): string
    {
        return hash('sha256', Str::lower($email));
    }
}
