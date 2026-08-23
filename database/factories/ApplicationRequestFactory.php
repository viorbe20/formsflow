<?php

namespace Database\Factories;

use App\Models\ApplicationRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ApplicationRequest>
 */
class ApplicationRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Applicant information.
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),

            // Organization and destination unit.
            'organization' => fake()->company(),
            'unit' => fake()->jobTitle(),

            // Request information.
            'subject' => fake()->sentence(4),
            'statement' => fake()->paragraph(),
            'request_text' => fake()->paragraph(),

            // Default application state.
            'status' => 'pending',

            // Optional fields populated later by the application workflow.
            'category' => null,
            'priority' => null,
        ];
    }
}
