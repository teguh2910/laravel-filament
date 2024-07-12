<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Supplier;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $uniqueUsers = User::count();
        $uniqueSuppliers = Supplier::count();
        return [
            Stat::make('User', $uniqueUsers)
                ->description('Total User Registered')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Supplier', $uniqueSuppliers)
                ->description('Total Supplier Registered')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
