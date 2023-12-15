<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Enums\RoleEnum;
use App\Models\Indicator;
use App\Models\Process;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Structures', User::all()->filter(fn ($user) => $user->hasRole(RoleEnum::STRUCTURE))->count())
                ->description('Nombre total des structures gérés')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Processus', Process::count())
                ->description('Nombre total des processus gérés')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ])->url(route('filament.admin.resources.processes.index')),

            Stat::make('Indicateur', Indicator::count())
                ->description('Nombre total des indicateurs gérés')
                ->color('amber')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ])->url(route('filament.admin.resources.indicators.index')),

        ];
    }
}
