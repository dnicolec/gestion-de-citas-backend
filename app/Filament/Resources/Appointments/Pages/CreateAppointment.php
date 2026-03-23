<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

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
