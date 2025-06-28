<?php

namespace App\Filament\Resources\QualificationTypeResource\Pages;

use App\Filament\Resources\QualificationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQualificationType extends EditRecord
{
    protected static string $resource = QualificationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
