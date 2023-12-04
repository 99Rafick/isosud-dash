<?php

namespace Database\Factories;

use App\Enums\StructureEnum;
use App\Models\Structure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Structure>
 */
class StructureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'domain' => collect(StructureEnum::DOMAIN)->random(),
            'sector' => collect(StructureEnum::SECTOR)->random(),
            'logo' => $this->faker->imageUrl,
        ];
    }
}
