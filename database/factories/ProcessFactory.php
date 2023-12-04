<?php

namespace Database\Factories;

use App\Enums\ProcessEnum;
use App\Enums\StructureEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Process>
 */
class ProcessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'category' => collect(ProcessEnum::class)->random(),
            'structure_id' => 1
        ];
    }
}
