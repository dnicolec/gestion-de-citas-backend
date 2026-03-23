<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PatientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Personal')
                    ->schema([
                        TextEntry::make('given_name')
                            ->label('Nombre'),

                        TextEntry::make('family_name')
                            ->label('Apellido'),

                        TextEntry::make('id_document')
                            ->label('Documento'),

                        TextEntry::make('birth_date')
                            ->label('Fecha de nacimiento')
                            ->date('d/m/Y'),

                        TextEntry::make('gender')
                            ->label('Género')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'masculino' => 'info',
                                'femenino' => 'success',
                                default => 'gray',
                            }),

                        TextEntry::make('phone_number')
                            ->label('Teléfono'),

                        TextEntry::make('email_address')
                            ->label('Correo'),

                        TextEntry::make('home_address')
                            ->label('Dirección'),
                    ])
                    ->columns(2),

                Section::make('Contacto de Emergencia')
                    ->schema([
                        TextEntry::make('emergency_contact_name')
                            ->label('Contacto'),

                        TextEntry::make('emergency_contact_phone')
                            ->label('Teléfono'),
                    ])
                    ->columns(2),

                Section::make('Expediente Clínico')
                    ->schema([
                        TextEntry::make('medicalRecord.blood_type')
                            ->label('Tipo de sangre')
                            ->badge()
                            ->color('danger'),

                        TextEntry::make('medicalRecord.known_allergies')
                            ->label('Alergias'),

                        TextEntry::make('medicalRecord.chronic_conditions')
                            ->label('Condiciones crónicas'),

                        TextEntry::make('medicalRecord.current_medications')
                            ->label('Medicamentos'),

                        TextEntry::make('medicalRecord.family_background')
                            ->label('Antecedentes familiares'),

                        TextEntry::make('medicalRecord.notes')
                            ->label('Notas'),
                    ])
                    ->columns(2),
            ]);
    }
}