<?php

namespace Database\Factories;

use App\Models\UiSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UiSetting>
 */
class UiSettingFactory extends Factory
{
    /**
     * @var class-string<UiSetting>
     */
    protected $model = UiSetting::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'org_name' => 'Bicutan Parochial School',
            'org_initial' => 'BPS',
            'org_address' => fake()->address(),
            'org_logo' => '',
            'org_logo_full' => '',
            'email' => 'library@bps.edu.ph',
            'contact_number' => fake()->numerify('09#########'),
            'social_links' => [
                'facebook' => 'https://facebook.com/bpslibrary',
                'email' => 'library@bps.edu.ph',
            ],
            'theme_colors' => [
                'primary' => '#0f766e',
                'secondary' => '#f1f5f9',
                'tertiary' => '#14b8a6',
            ],
        ];
    }
}
