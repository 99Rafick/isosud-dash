<?php

namespace App\Filament\Resources;

use App\Enums\FilamentEnum;
use App\Enums\ProcessEnum;
use App\Enums\RoleEnum;
use App\Enums\StructureEnum;
use App\Filament\Resources\ProcessResource\Pages;
use App\Filament\Resources\ProcessResource\RelationManagers;
use App\Models\Process;
use App\Models\Structure;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProcessResource extends Resource
{
    protected static ?string $model = Process::class;

    protected static ?string $navigationGroup = 'Elémént';

    protected static ?string $modelLabel = 'Processus';

    protected static ?string $pluralModelLabel = 'Processus';

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        $eloquentQuery = parent::getEloquentQuery();

        if(!RoleEnum::isAdmin()) {
            $eloquentQuery = $eloquentQuery->where('user_id', '=', Auth::user()->id);
        }

        return $eloquentQuery;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(FilamentEnum::FORM_SECTION_TITLE)
                    ->description(FilamentEnum::FORM_SECTION_DESCRIPTION)
                    ->schema([
                        Select::make('user_id')
                            ->label('Structure')
                            ->hidden(!RoleEnum::isAdmin())
                            ->native(false)
                            ->options(User::all()->filter(fn ($user) => $user->hasRole(RoleEnum::STRUCTURE))->pluck('name', 'id'))
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
                    ->hidden(!RoleEnum::isAdmin())
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
