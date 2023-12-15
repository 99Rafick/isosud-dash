<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Enums\RoleEnum;
use App\Models\Structure;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Structures extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(User::whereHas('roles', fn ($query) => $query->where('roles.name', RoleEnum::STRUCTURE)))
            ->columns([
                Tables\Columns\ImageColumn::make('logo'),
                Tables\Columns\TextColumn::make('name')->label('Nom'),
                Tables\Columns\TextColumn::make('sector')->label('Secteur'),
                Tables\Columns\TextColumn::make('domain')->label('Domaine'),
            ])->actions([
                Action::make('Processus')
                    ->url('iii')
            ]);
    }
}
