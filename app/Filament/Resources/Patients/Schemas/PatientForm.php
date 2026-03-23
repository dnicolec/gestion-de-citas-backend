<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Personal')
                    ->schema([
                        TextInput::make('given_name')
                            ->label('Nombre')
                            ->required(),

                        TextInput::make('family_name')
                            ->label('Apellido')
                            ->required(),

                        TextInput::make('id_document')
                            ->label('DUI / Documento')
                            ->unique(ignoreRecord: true),

                        DatePicker::make('birth_date')
                            ->label('Fecha de nacimiento')
                            ->required(),

                        Select::make('gender')
                            ->label('Género')
                            ->options([
                                'masculino' => 'Masculino',
                                'femenino' => 'Femenino',
                                'otro' => 'Otro',
                            ])
                            ->required(),

                        TextInput::make('phone_number')
                            ->label('Teléfono')
                            ->tel(),

                        TextInput::make('email_address')
                            ->label('Correo electrónico')
                            ->email(),

                        Textarea::make('home_address')
                            ->label('Dirección')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Contacto de Emergencia')
                    ->schema([
                        TextInput::make('emergency_contact_name')
                            ->label('Nombre del contacto')
                            ->required(),

                        TextInput::make('emergency_contact_phone')
                            ->label('Teléfono de emergencia')
                            ->tel()
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Expediente Clínico')
                    ->relationship('medicalRecord')
                    ->schema([
                        Select::make('blood_type')
                            ->label('Tipo de sangre')
                            ->options([
                                'A+' => 'A+',
                                'A-' => 'A-',
                                'B+' => 'B+',
                                'B-' => 'B-',
                                'O+' => 'O+',
                                'O-' => 'O-',
                                'AB+' => 'AB+',
                                'AB-' => 'AB-',
                            ]),

                        Textarea::make('known_allergies')
                            ->label('Alergias conocidas'),

                        Textarea::make('chronic_conditions')
                            ->label('Condiciones crónicas'),

                        Textarea::make('current_medications')
                            ->label('Medicamentos actuales'),

                        Textarea::make('family_background')
                            ->label('Antecedentes familiares'),

                        Textarea::make('notes')
                            ->label('Notas')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}