<?php

namespace App\Filament\Resources\IndicatorResource\Pages;

use App\Filament\Resources\IndicatorResource;
use App\Models\Indicator;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateIndicator extends CreateRecord
{
    protected static string $resource = IndicatorResource::class;

//    protected function handleRecordCreation(array $data): Model
//    {
//        if ($data['target_type'] === 'date') {
//            $data['target'] = $data['target2'];
//        }
//        return Indicator::create($data);
//    }
}
