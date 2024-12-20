<?php

namespace App\Filament\Widgets;

use App\Models\Note;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            stat::make('Total users', User::count())
                ->description('Total users in this website')
                ->descriptionIcon('heroicon-s-users')
                ->color('success'),
            stat::make('Total notes', Note::count())
                ->description('Increase in uploading notes')
                ->descriptionIcon('heroicon-s-arrow-trending-up')
                ->color('success'),
            
        ];
    }
}
