<?php

namespace Database\Seeders;

use App\Enums\IndicatorFrequencyEnum;
use App\Models\IndicatorFrequency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndicatorFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IndicatorFrequency::create([
            'name' => 'Mensuel',
            'month_or_year' => IndicatorFrequencyEnum::MONTH_OR_YEAR['month'],
            'number_of_month_or_year' => 1
        ]);

        IndicatorFrequency::create([
            'name' => 'Trimestriel',
            'month_or_year' => IndicatorFrequencyEnum::MONTH_OR_YEAR['month'],
            'number_of_month_or_year' => 3
        ]);

        IndicatorFrequency::create([
            'name' => 'Semestriel',
            'month_or_year' => IndicatorFrequencyEnum::MONTH_OR_YEAR['month'],
            'number_of_month_or_year' => 6
        ]);

        IndicatorFrequency::create([
            'name' => 'Annuel',
            'month_or_year' => IndicatorFrequencyEnum::MONTH_OR_YEAR['year'],
            'number_of_month_or_year' => 1
        ]);
    }
}
