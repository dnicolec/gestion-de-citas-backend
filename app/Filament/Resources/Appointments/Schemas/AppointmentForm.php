<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Patient;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('patient_id')
                    ->label('Paciente')
                    ->options(
                        Patient::query()
                            ->orderBy('given_name')
                            ->get()
                            ->mapWithKeys(fn (Patient $patient) => [
                                $patient->id => $patient->full_name,
                            ])
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('doctor_id')
                    ->label('Médico')
                    ->options(
                        User::query()
                            ->where('role', 'medico')
                            ->where('is_active', true)
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('appointment_date')
                    ->label('Fecha')
                    ->required(),

                TimePicker::make('start_time')
                    ->label('Hora de inicio')
                    ->seconds(false)
                    ->required(),

                TimePicker::make('end_time')
                    ->label('Hora de fin')
                    ->seconds(false)
                    ->required(),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'programada' => 'Programada',
                        'completada' => 'Completada',
                        'cancelada' => 'Cancelada',
                    ])
                    ->default('programada')
                    ->required(),

                Textarea::make('visit_reason')
                    ->label('Motivo de consulta')
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('notes')
                    ->label('Notas')
                    ->columnSpanFull(),
            ]);
    }
}