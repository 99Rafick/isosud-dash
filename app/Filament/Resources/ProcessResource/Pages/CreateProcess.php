<?php

namespace App\Filament\Resources\ProcessResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\ProcessResource;
use App\Models\Process;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateProcess extends CreateRecord
{
    protected static string $resource = ProcessResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        if (!RoleEnum::isAdmin()) {
            $data['user_id'] = Auth::user()->id;
        }
        return Process::create($data);
    }
}
