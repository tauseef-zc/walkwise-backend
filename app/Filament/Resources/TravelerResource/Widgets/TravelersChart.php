<?php

namespace App\Filament\Resources\TravelerResource\Widgets;

use App\Models\Traveler;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TravelersChart extends ChartWidget
{
    protected static ?string $heading = 'Travelers';

    protected function getData(): array
    {
        $data = Trend::model(Traveler::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Travelers registered',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
