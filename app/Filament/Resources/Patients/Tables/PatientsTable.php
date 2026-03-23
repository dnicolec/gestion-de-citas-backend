<?php

namespace App\Filament\Resources\Patients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('given_name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('family_name')
                    ->label('Apellido')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('id_document')
                    ->label('Documento')
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->label('Teléfono'),

                TextColumn::make('gender')
                    ->label('Género')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'masculino' => 'info',
                        'femenino' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('medicalRecord.blood_type')
                    ->label('Sangre')
                    ->badge()
                    ->color('danger'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}