<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CitasChart extends ChartWidget
{
    protected ?string $heading = 'Citas Diarias';
    protected ?string $desciption = 'Citas diarias programadas esta semana';

    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    protected function getOptions(): array|RawJs|null
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'elements' => [
                'point' => ['radius' => 6, 'hoverRadius' => 10],
            ],
        ];
    }

    protected function getData(): array
    {
        $dates = [];
        $counts = [];

        $citasDiarias = Appointment::select(
            DB::raw('DATE(appointment_date) as date'),
            DB::raw('count(*) as total')
        )->groupBy('date')->orderBy('date', 'asc')->limit(7)->pluck('total', 'date');



        return [
            'datasets' => [
                [
                    'label' => 'Citas progradas esta semana',
                    'data' => $citasDiarias->values()->toArray(),
                    'fill' => 'origin',
                    'tension' => 0.4
                ],
            ],
            'labels' => $citasDiarias->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
