<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->syncRoles([$this->record->role]);
    }

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