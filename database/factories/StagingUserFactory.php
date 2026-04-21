<?php

namespace Database\Factories;

use App\Models\StagingUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<StagingUser>
 */
class StagingUserFactory extends Factory
{
    /**
     * @var class-string<StagingUser>
     */
    protected $model = StagingUser::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userType = fake()->randomElement(['student', 'employee', 'visitor']);

        return [
            'rfid' => sprintf('SRF%07d', fake()->unique()->numberBetween(1, 9999999)),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->boolean(30) ? fake()->lastName() : null,
            'last_name' => fake()->lastName(),
            'suffix' => null,
            'gender' => fake()->randomElement(['Male', 'Female', 'Prefer not to say']),
            'email' => Str::lower(fake()->unique()->safeEmail()),
            'password' => Hash::make('password'),
            'profile_image' => null,
            'user_type' => $userType,
            'id_number' => $userType === 'student' ? sprintf('STG%08d', fake()->numberBetween(1, 99999999)) : null,
            'level' => $userType === 'student' ? fake()->randomElement(['Grade 11', 'Grade 12']) : null,
            'section' => $userType === 'student' ? fake()->randomElement(['A', 'B', 'C']) : null,
            'employee_id' => $userType === 'employee' ? sprintf('SEMP%06d', fake()->numberBetween(1, 999999)) : null,
            'employee_role' => $userType === 'employee' ? fake()->randomElement(['Teacher', 'Librarian', 'Staff']) : null,
            'school_org' => $userType === 'visitor' ? fake()->company() : null,
            'purpose' => $userType === 'visitor' ? fake()->randomElement(['Research', 'Visit', 'Reference']) : null,
        ];
    }
}
