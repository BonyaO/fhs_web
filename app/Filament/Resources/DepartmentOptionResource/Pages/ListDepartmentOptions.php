<?php

namespace App\Filament\Resources\DepartmentOptionResource\Pages;

use App\Filament\Resources\DepartmentOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepartmentOptions extends ListRecords
{
    protected static string $resource = DepartmentOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
