<?php

namespace App\Filament\Pages;

use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Filament\Pages\Page;

class CalendarioMedicos extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Disponibilidad Médica';
    protected string $view = 'filament.pages.calendario-medicos';

    public $month;
    public $year;

    public function mount()
    {
        $this->month = now()->month;
        $this->year = now()->year;
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole(['admin', 'medico']) ?? false;
    }

    public function getViewData(): array
    {
        $user = auth()->user();

        // Seguridad
        $query = DoctorSchedule::with('doctor');

        if ($user && $user->hasRole('medico')) {
            $query->where('user_id', $user->id);
        }

        $horarios = $query->get();


        $fechaActual = Carbon::create($this->year, $this->month, 1);
        $diasMes = [];
        $inicioMes = $fechaActual->copy()->startOfMonth();
        $finMes = $fechaActual->copy()->endOfMonth();

        $mapDias = ['domingo' => 0, 'lunes' => 1, 'martes' => 2, 'miercoles' => 3, 'jueves' => 4, 'viernes' => 5, 'sabado' => 6];

        for ($date = $inicioMes->copy(); $date->lte($finMes); $date->addDay()) {
            $turnosHoy = [];

            foreach ($horarios as $h) {
                $diaLimpio = strtolower(str_replace(['é', 'á', 'í', 'ó', 'ú'], ['e', 'a', 'i', 'o', 'u'], $h->day_of_week));

                if (($mapDias[$diaLimpio] ?? -1) === $date->dayOfWeek) {

                    $inicio = Carbon::parse($h->start_time)->format('H:i');
                    $fin = Carbon::parse($h->end_time)->format('H:i');

                    $turnosHoy[] = [
                        'medico' => $h->doctor->name ?? 'Médico',
                        'hora' => "{$inicio} - {$fin}"
                    ];
                }
            }

            $diasMes[] = [
                'fecha' => $date->copy(),
                'turnos' => $turnosHoy
            ];
        }

        return [
            'diasMes' =>  $diasMes,
            'inicioMes' => $inicioMes,
            'nombreMes' => $fechaActual->locale('es')->isoFormat('MMMM YYYY'),
        ];
    }
    public function irMesAnterior($m, $y)
    {
        $this->month = $m;
        $this->year = $y;
    }

    public function irMesSiguiente($m, $y)
    {
        $this->month = $m;
        $this->year = $y;
    }
}
