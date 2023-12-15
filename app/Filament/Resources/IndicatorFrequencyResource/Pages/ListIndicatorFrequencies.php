<?php

namespace App\Filament\Resources\IndicatorFrequencyResource\Pages;

use App\Filament\Resources\IndicatorFrequencyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIndicatorFrequencies extends ListRecords
{
    protected static string $resource = IndicatorFrequencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
