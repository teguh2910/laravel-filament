<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use App\Models\Supplier;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'Supplier';

    protected function getData(): array
    {
        $suppliers = Supplier::all()->groupBy('jenis_supplier')->map(function ($row) {
            return $row->count();
        });
        // Get labels and data from the $suppliers collection
        $labels = $suppliers->keys()->toArray();
        $data = $suppliers->values()->toArray();
        // Generate random colors for each label
        $backgroundColor = array_map(function () {
            return sprintf('rgb(%d, %d, %d)', rand(0, 255), rand(0, 255), rand(0, 255));
        }, $labels);
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
    protected function getFilters(): ?array
    {
        return [];
    }
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => false,
                ],
                'y' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
