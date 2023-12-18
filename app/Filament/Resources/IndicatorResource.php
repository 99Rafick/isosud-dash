<?php

namespace App\Filament\Resources;

use App\Enums\FilamentEnum;
use App\Enums\IndicatorEnum;
use App\Enums\ProcessEnum;
use App\Filament\Resources\IndicatorResource\Pages;
use App\Filament\Resources\IndicatorResource\RelationManagers;
use App\Models\Indicator;
use App\Models\IndicatorFrequency;
use App\Models\Process;
use App\Models\Structure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;

class IndicatorResource extends Resource
{
    protected static ?string $model = Indicator::class;
    protected static ?string $modelLabel = 'Indicateur';
    protected static ?string $navigationGroup = 'Elémént';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(FilamentEnum::FORM_SECTION_TITLE)
                    ->description(FilamentEnum::FORM_SECTION_DESCRIPTION)
                    ->schema([
                        Select::make('process_id')
                            ->label('Nom du processus')
                            ->native(false)
                            ->options(Process::pluck('name', 'id'))
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('name')
                            ->label("Intitulé de l'indicateur")
                            ->required()
                            ->columnSpanFull(),
                        Select::make('indicator_frequency_id')
                            ->label('Fréquence')
                            ->native(false)
                            ->options(IndicatorFrequency::pluck('name', 'id'))
                            ->required(),
                        Select::make('operator')
                            ->label('Opérateur')
                            ->native(false)
                            ->options(collect(IndicatorEnum::OPERATOR))
                            ->required(),
                        Select::make('target_type')
                            ->label('Type de la cible')
                            ->native(false)
                            ->options(IndicatorEnum::TARGET_TYPE)
                            ->required()
                            ->columnSpanFull()
                            ->reactive(),
                        Forms\Components\TextInput::make('number_target')
                            ->label('Cîble')
                            ->minValue(0)
                            ->maxValue(fn (callable $get) =>  $get('target_type') === IndicatorEnum::TARGET_TYPE['nombre'] ? null : 100)
                            ->required()
                            ->numeric()
                            ->columnSpanFull()
                            ->maxLength(255)
                            ->hidden(fn (callable $get) => $get('target_type') === 'date'),
                        Forms\Components\DatePicker::make('date_target')
                            ->label('Cîble')
                            ->native(false)
                            ->columnSpanFull()
                            ->required()
                            ->hidden(fn (callable $get) => $get('target_type') !== strtolower(IndicatorEnum::TARGET_TYPE['date'])),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('process_id')
                    ->label('Processus')
                    ->getStateUsing(fn($record) => $record->process->name)
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->getStateUsing(fn ($record) => Str::limit($record->name, 20))
                    ->searchable(),
                Tables\Columns\TextColumn::make('indicator_frequency_id')
                    ->label('Fréquence')
                    ->getStateUsing(fn($record) => $record->frequency->name)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('operator')
                    ->label('Operateur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('target')
                    ->label('Cible')
                    ->getStateUsing(function ($record) {
                        if ($record->target_type === IndicatorEnum::TARGET_TYPE['nombre']) {
                            $target = $record->number_target;
                        } elseif ($record->target_type === IndicatorEnum::TARGET_TYPE['date']) {
                            $target = $record->date_target;
                        } else {
                            $target = $record->number_target . '%';
                        }
                        return $target;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndicators::route('/'),
            'create' => Pages\CreateIndicator::route('/create'),
            'edit' => Pages\EditIndicator::route('/{record}/edit'),
        ];
    }
}
