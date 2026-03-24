<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class StatsOverview extends StatsOverviewWidget
{

    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getColumns(): int|array|null
    {
        return 2;
    }

    protected function getStats(): array
    {
        $pacientes = User::count();
        $citasHoy = Appointment::whereDate('appointment_date', today())->count();
        return [
            Stat::make("Pacientes", $pacientes)->description("Registrados en el sistema")->descriptionIcon("heroicon-m-user-group")->color('info')->extraAttributes([
                'class' => 'cursor-pointer hover:scale-[1.02] transition-transform duration-300 shadow-sm text-center flex flex-col items-center justify-center'
            ]),
            Stat::make("Citas del día", $citasHoy)->description(Carbon::today()->locale('es')->isoFormat('D [de] MMMM'))->descriptionIcon("heroicon-m-calendar-days")->color('success')->extraAttributes([
                'class' => 'cursor-pointer hover:scale-[1.02] transition-transform duration-300 shadow-sm text-center flex flex-col items-center justify-center'
            ]),
        ];
    }
}
