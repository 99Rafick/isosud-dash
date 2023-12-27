<?php

namespace App\Filament\Resources\ProcessResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\ProcessResource;
use App\Models\Process;
use App\Models\User;
use Filament\Resources\Pages\Page;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;


class ProcessByStructure extends Page implements HasTable
{
    use InteractsWithTable;

    private int | string $userId;
    private Model $model;

    protected static string $resource = ProcessResource::class;

    protected static ?string $title = "Processus";

    protected static string $view = 'filament.resources.process-resource.pages.process-by-structure';

    public function mount(int | string $structure): void
    {
        $model = User::find($structure);

        if ($model ===  null) {
            abort(404);
        }
        $this->userId = $structure;
        $this->model = $model;

        static::authorizeResourceAccess();
    }


    public function table(Table $table): Table
    {
        return $table
            ->description('Structure: ' . $this->model->name)
            ->query(Process::where('user_id', '=', $this->userId))
            ->columns([
                Stack::make([
                    Tables\Columns\TextColumn::make('category')
                        ->label('Catégorie')
                        ->searchable()
                        ->badge(),
                    Tables\Columns\TextColumn::make('name')
                        ->label('Nom')
                        ->extraAttributes(['class' => 'mt-3']),

                ]),

            ])->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])->actions([
                Action::make('Indicateur')
                    ->url(fn($record) => route('filament.admin.resources.processes.show_by_structure', ['structure' => $record->id]))
                    ->extraAttributes(['style' => 'justify-content: flex-end !important'])
            ]);
    }



}
