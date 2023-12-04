<?php

namespace App\Filament\Resources;

use App\Enums\FilamentEnum;
use App\Enums\StructureEnum;
use App\Filament\Resources\StructureResource\Pages;
use App\Filament\Resources\StructureResource\RelationManagers;
use App\Models\Structure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class StructureResource extends Resource
{
    protected static ?string $model = Structure::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(FilamentEnum::FORM_SECTION_TITLE)
                    ->description(FilamentEnum::FORM_SECTION_DESCRIPTION)
                    ->schema([
                        Forms\Components\Textarea::make('name')
                            ->label('Nom')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('domain')
                            ->label('Domaine')
                            ->native(false)
                            ->options(StructureEnum::DOMAIN)
                            ->required(),
                        Select::make('sector')
                            ->label('Secteur')
                            ->native(false)
                            ->options(StructureEnum::SECTOR)
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make('Le Logo de la direction')
                    ->description("Ce renseignement n'est pas obligatoire")
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                'domain',
                'sector',
            ])
            ->columns([
                Tables\Columns\ImageColumn::make('logo'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('domain')
                    ->label('Domaine')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sector')
                    ->label('Secteur')
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
            'index' => Pages\ListStructures::route('/'),
            'create' => Pages\CreateStructure::route('/create'),
            'edit' => Pages\EditStructure::route('/{record}/edit'),
        ];
    }
}
