<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Carbon\Carbon;
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
        $citasDiarias = Appointment::select(
            DB::raw('DATE(appointment_date) as date'),
            DB::raw('count(*) as total')
        )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->limit(30)
            ->get();

        $labels = $citasDiarias->map(function ($item) {
            return Carbon::parse($item->date)->locale('es')->isoFormat('D MMM');
        })->toArray();

        $data = $citasDiarias->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Citas progradas esta semana',
                    'data' => $data,
                    'fill' => 'origin',
                    'tension' => 0.4
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
