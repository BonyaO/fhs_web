<?php

namespace App\Filament\Resources\EditorialBoardResource\Pages;

use App\Filament\Resources\EditorialBoardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEditorialBoards extends ListRecords
{
    protected static string $resource = EditorialBoardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
