<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Guide;
use App\Models\Tour;
use App\Models\Traveler;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Total Tours', Tour::count() )
                ->icon('heroicon-s-map')
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Total Bookings', Booking::count())
                ->icon('heroicon-s-currency-dollar')
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-down'),
            Stat::make('Total Guides', Guide::count())
                ->icon('heroicon-s-user-group')
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Total Travelers', Traveler::count())
                ->icon('heroicon-s-user')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }
}
