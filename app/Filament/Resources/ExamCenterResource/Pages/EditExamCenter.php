<?php

namespace App\Filament\Resources\ExamCenterResource\Pages;

use App\Filament\Resources\ExamCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExamCenter extends EditRecord
{
    protected static string $resource = ExamCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
