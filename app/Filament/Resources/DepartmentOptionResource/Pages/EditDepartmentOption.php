<?php

namespace App\Filament\Resources\DepartmentOptionResource\Pages;

use App\Filament\Resources\DepartmentOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepartmentOption extends EditRecord
{
    protected static string $resource = DepartmentOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
