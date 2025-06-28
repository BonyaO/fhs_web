<?php

namespace App\Filament\Resources\SubDivisionResource\Pages;

use App\Filament\Resources\SubDivisionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubDivision extends EditRecord
{
    protected static string $resource = SubDivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
