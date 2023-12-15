<?php

namespace App\Filament\Resources\IndicatorResource\Pages;

use App\Filament\Resources\IndicatorResource;
use App\Models\Indicator;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditIndicator extends EditRecord
{
    protected static string $resource = IndicatorResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if ($data['target_type'] === 'date') {
            $data['target'] = $data['target2'];
            unset($data['target2']);
        }
        Indicator::where('id', $record->id)
            ->update($data);

        return Indicator::find($record->id);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
