<?php

namespace App\Filament\Resources;

use App\Enums\FilamentEnum;
use App\Enums\RoleEnum;
use App\Enums\StructureEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
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

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $modelLabel = 'Utilisateur';

    protected static ?int $navigationSort = 6;
    protected static ?string $navigationIcon = 'heroicon-o-users';


    public static function canViewAny(): bool
    {
        return RoleEnum::isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(FilamentEnum::FORM_SECTION_TITLE)
                    ->description(FilamentEnum::FORM_SECTION_DESCRIPTION)
                    ->schema([
                        Forms\Components\Textarea::make('name')
                            ->label('Nom')
                            ->unique()
                            ->required()
                            ->columnSpanFull(),

                        //todo: hidden if is editing
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique()
                            ->required(),
                        Select::make('role')
                            ->options(RoleEnum::values())
                            ->required()
                            ->native(false)
                            ->reactive()
                    ])->columns(2),

                Forms\Components\Section::make('Structure')
                    ->description('Information complémentaire de la structure')
                    ->schema([
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
                        Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->columnSpanFull(),
                    ])->columns(2)->hidden(fn (callable $get) => $get('role') !== RoleEnum::STRUCTURE),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
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

    private static function isEditing(): bool
    {
        return request()->routeIs('filament.admin.resources.users.edit');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
