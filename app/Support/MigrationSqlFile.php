<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RuntimeException;

final class MigrationSqlFile
{
    /**
     * Execute a named SQL section from a database/sql file.
     */
    public static function runSection(string $relativePath, string $sectionName): void
    {
        DB::unprepared(self::readSection($relativePath, $sectionName));
    }

    /**
     * Read a named SQL section from a database/sql file.
     */
    public static function readSection(string $relativePath, string $sectionName): string
    {
        $path = database_path('sql/' . ltrim($relativePath, '/'));

        if (! File::exists($path)) {
            throw new RuntimeException("SQL file does not exist: {$path}");
        }

        $content = File::get($path);
        $pattern = '/--\s*\[' . preg_quote($sectionName, '/') . '\]\R(.*?)\R--\s*\[end\]/s';

        if (! preg_match($pattern, $content, $matches)) {
            throw new RuntimeException("SQL section [{$sectionName}] was not found in {$path}");
        }

        $sql = trim($matches[1]);

        if ($sql === '') {
            throw new RuntimeException("SQL section [{$sectionName}] is empty in {$path}");
        }

        return $sql;
    }
}
