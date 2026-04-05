<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

/**
 * Represents the UI and branding settings for the organization.
 *
 * @property int $id
 * @property string|null $org_name
 * @property string|null $org_initial
 * @property string|null $org_address
 * @property string|null $org_logo Base64-encoded small logo (BLOB)
 * @property string|null $org_logo_full Base64-encoded full/large logo (BLOB)
 * @property string|null $email
 * @property string|null $contact_number
 * @property array|null $social_links JSON column
 * @property array|null $theme_colors JSON column with primary/secondary/tertiary hex values
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string|null $org_logo_base64
 * @property-read string|null $org_logo_full_base64
 */
class UiSetting extends Model
{
    use SoftDeletes;

    /**
     * Boot the model and register cache invalidation events.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saved(fn () => Cache::forget('ui_settings'));
        static::deleted(fn () => Cache::forget('ui_settings'));
    }

    /**
     * @var string
     */
    protected $table = 'ui_settings';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array<int, string>
     */
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

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'social_links' => 'array',
        'theme_colors' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Hide raw logo BLOB fields from serialization to avoid duplicating large payloads.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'org_logo',
        'org_logo_full',
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'org_logo_base64',
        'org_logo_full_base64',
    ];

    /**
     * Get the org_logo as a base64 data URL for display.
     */
    public function getOrgLogoBase64Attribute(): ?string
    {
        if (! $this->org_logo) {
            return null;
        }

        return 'data:image/png;base64,' . $this->org_logo;
    }

    /**
     * Get the org_logo_full as a base64 data URL for display.
     */
    public function getOrgLogoFullBase64Attribute(): ?string
    {
        if (! $this->org_logo_full) {
            return null;
        }

        return 'data:image/png;base64,' . $this->org_logo_full;
    }
}
