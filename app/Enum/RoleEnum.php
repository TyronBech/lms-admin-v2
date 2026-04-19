<?php

namespace App\Enum;

enum RoleEnum: string
{
    case SuperAdmin = 'Super Admin';
    case Admin = 'Admin';
    case Librarian = 'Librarian';
    case Immersion = 'Immersion';
    case Encoder = 'Encoder';

    /**
     * Returns the list of roles permitted to access the Admin portal.
     *
     * @return array<string>
     */
    public static function adminPortalRoles(): array
    {
        return array_map(
            static fn (self $role): string => $role->value,
            self::cases(),
        );
    }
}
