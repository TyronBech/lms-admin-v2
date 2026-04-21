<?php

namespace Database\Factories;

use App\Models\SystemSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SystemSetting>
 */
class SystemSettingFactory extends Factory
{
    /**
     * @var class-string<SystemSetting>
     */
    protected $model = SystemSetting::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $key = 'setting.' . fake()->unique()->slug(3);

        return [
            'key' => $key,
            'value' => (string) fake()->numberBetween(1, 10),
            'description' => 'Auto-generated setting for ' . $key,
        ];
    }
}
