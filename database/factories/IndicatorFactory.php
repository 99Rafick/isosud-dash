<?php

namespace Database\Factories;

use App\Enums\IndicatorEnum;
use App\Models\Indicator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Indicator>
 */
class IndicatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $targetType = collect(IndicatorEnum::TARGET_TYPE)->random();
        return [
            'name' => $this->faker->text(),
            'operator' => collect(IndicatorEnum::OPERATOR)->random(),
            'target_type' => $targetType,
            'number_target' => $targetType !== IndicatorEnum::TARGET_TYPE['date'] ? 80 : null,
            'date_target' => $targetType === IndicatorEnum::TARGET_TYPE['date'] ? $this->faker->date : null,
            'indicator_frequency_id' => 1,
            'process_id' => 1
        ];
    }
}
