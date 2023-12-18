<?php

namespace App\Filament\Resources;

use App\Enums\IndicatorFrequencyEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\IndicatorFrequencyResource\Pages;
use App\Filament\Resources\IndicatorFrequencyResource\RelationManagers;
use App\Models\IndicatorFrequency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndicatorFrequencyResource extends Resource
{
    protected static ?string $model = IndicatorFrequency::class;

    protected static ?string $modelLabel = "Fréquence d'Indicateur";
    protected static ?string $navigationGroup = 'Paramètre';
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return RoleEnum::isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label("Nom")
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('month_or_year')
                    ->label("Mois/Année")
                    ->options(IndicatorFrequencyEnum::MONTH_OR_YEAR)
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('number_of_month_or_year')
                    ->label("Nombre de Mois/Année")
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Nom")
                    ->searchable(),
                Tables\Columns\TextColumn::make('month_or_year')
                    ->label("Mois/Année")
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_month_or_year')
                    ->label("Nombre de Mois/Année")
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListIndicatorFrequencies::route('/'),
            'create' => Pages\CreateIndicatorFrequency::route('/create'),
            'edit' => Pages\EditIndicatorFrequency::route('/{record}/edit'),
        ];
    }
}
