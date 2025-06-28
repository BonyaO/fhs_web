<?php

namespace App\Filament\Resources\QualificationTypeResource\Pages;

use App\Filament\Resources\QualificationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQualificationTypes extends ListRecords
{
    protected static string $resource = QualificationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
