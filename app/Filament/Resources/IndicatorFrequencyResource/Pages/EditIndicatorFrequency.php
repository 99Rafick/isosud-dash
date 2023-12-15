<?php

namespace App\Filament\Resources\IndicatorFrequencyResource\Pages;

use App\Filament\Resources\IndicatorFrequencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIndicatorFrequency extends EditRecord
{
    protected static string $resource = IndicatorFrequencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
