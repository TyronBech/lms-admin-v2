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
        if (! $this->org_logo) {
            return null;
        }

        return 'data:image/png;base64,'.base64_encode($this->org_logo);
    }

    /**
     * Get the org_logo_full as a base64 data URL for display
     */
    public function getOrgLogoFullBase64Attribute(): ?string
    {
        if (! $this->org_logo_full) {
            return null;
        }

        return 'data:image/png;base64,'.base64_encode($this->org_logo_full);
    }
}
