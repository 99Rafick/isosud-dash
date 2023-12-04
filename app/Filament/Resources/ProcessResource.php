<?php

namespace App\Filament\Resources;

use App\Enums\FilamentEnum;
use App\Enums\ProcessEnum;
use App\Enums\StructureEnum;
use App\Filament\Resources\ProcessResource\Pages;
use App\Filament\Resources\ProcessResource\RelationManagers;
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

class ProcessResource extends Resource
{
    protected static ?string $model = Process::class;

    protected static ?string $modelLabel = 'Processus';

    protected static ?string $pluralModelLabel = 'Processus';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(FilamentEnum::FORM_SECTION_TITLE)
                    ->description(FilamentEnum::FORM_SECTION_DESCRIPTION)
                    ->schema([
                        Select::make('structure_id')
                            ->label('Structure')
                            ->native(false)
                            ->options(Structure::pluck('name', 'id'))
                            ->required(),
                        Forms\Components\Textarea::make('name')
                            ->label('Nom')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('category')
                            ->label('Catégorie')
                            ->native(false)
                            ->options(ProcessEnum::CATEGORY)
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                'category',
            ])
            ->columns([
                Tables\Columns\TextColumn::make('structure_id')
                    ->label('Structure')
                    ->getStateUsing(fn($record) => $record->structure->name)
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->numeric(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->sortable()
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
            ->paginated([10, 25, 50, 100, 'all'])
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
            'index' => Pages\ListProcesses::route('/'),
            'create' => Pages\CreateProcess::route('/create'),
            'edit' => Pages\EditProcess::route('/{record}/edit'),
        ];
    }
}
