<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UiSetting extends Model
{
    use SoftDeletes;

    protected $table = 'ui_settings';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'org_name',
        'org_initial',
        'org_address',
        'org_logo',
        'org_logo_full',
        'email',
        'contact_number',
        'social_links',
        'theme_colors',
    ];

    protected $casts = [
        'social_links' => 'array',
        'theme_colors' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'org_logo_base64',
        'org_logo_full_base64',
    ];

    /**
     * Get the org_logo as a base64 data URL for display
     */
    public function getOrgLogoBase64Attribute(): ?string
    {
        return $this->toImageDataUrl($this->org_logo);
    }

    /**
     * Get the org_logo_full as a base64 data URL for display
     */
    public function getOrgLogoFullBase64Attribute(): ?string
    {
        return $this->toImageDataUrl($this->org_logo_full);
    }

    /**
     * Normalize image storage formats into a PNG data URL.
     */
    private function toImageDataUrl(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        if (str_starts_with($value, 'data:image/')) {
            return $value;
        }

        // Some records are stored as raw binary, others as base64 text.
        $normalized = $this->looksLikeBase64($value)
            ? base64_decode($value, true)
            : false;

        $binary = $normalized !== false ? $normalized : $value;

        return 'data:image/png;base64,' . base64_encode($binary);
    }

    /**
     * Determine if the incoming string is likely a base64 payload.
     */
    private function looksLikeBase64(string $value): bool
    {
        if ($value === '') {
            return false;
        }

        if (strlen($value) % 4 !== 0) {
            return false;
        }

        return preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $value) === 1;
    }
}
