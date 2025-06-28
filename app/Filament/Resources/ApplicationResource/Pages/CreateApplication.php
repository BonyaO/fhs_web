<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use App\Filament\Resources\ApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApplication extends CreateRecord
{
    protected static string $resource = ApplicationResource::class;

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     dd($data);
    //
    //     return $data;
    // }
}
