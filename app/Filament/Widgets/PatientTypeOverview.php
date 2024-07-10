<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            stat::make('Cats', Patient::query()
                ->where('type', 'cat')
                ->count()),
            stat::make('Dogs', Patient::query()
                ->where('type', 'dog')
                ->count()),
            stat::make('Rabbits', Patient::query()
                ->where('type', 'rabbit')
                ->count()),
        ];
    }
}
