<?php

namespace App\Filament\Resources\QualificationResource\Pages;

use App\Filament\Resources\QualificationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQualification extends CreateRecord
{
    protected static string $resource = QualificationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        dd($data);
    }
}
