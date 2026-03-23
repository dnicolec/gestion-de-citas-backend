<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    public function getCreateButtonLabel(): string
    {
        return 'Crear';
    }

    public function getCreateAnotherButtonLabel(): string
    {
        return 'Crear y crear otro';
    }

    public function getCancelButtonLabel(): string
    {
        return 'Cancelar';
    }
}
