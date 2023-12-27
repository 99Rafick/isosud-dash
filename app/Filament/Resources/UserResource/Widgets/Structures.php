<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Enums\RoleEnum;
use App\Models\Structure;
use App\Models\User;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
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
                Stack::make([
                    Tables\Columns\ImageColumn::make('logo')
                        ->extraAttributes(['class' => 'col-span-1 mb-2']),
                    Tables\Columns\TextColumn::make('Info')
                        ->getStateUsing(fn($record) => 'Secteur ' . $record->sector . ', Domaine '. $record->domain)
                        ->badge()
                        ->color(Color::Gray)
                        ->extraAttributes([
                            'class' => 'text-md'
                        ]),
                    Tables\Columns\TextColumn::make('name')
                        ->label('Nom')
                        ->size(Tables\Columns\TextColumn\TextColumnSize::Large)
                        ->extraAttributes(['class' => 'mt-3']),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])->actions([
                Action::make('Processus')
                    ->url(fn($record) => route('filament.admin.resources.processes.show_by_structure', ['structure' => $record->id]))
                    ->extraAttributes(['style' => 'justify-content: flex-end !important'])
            ]);
    }
}
