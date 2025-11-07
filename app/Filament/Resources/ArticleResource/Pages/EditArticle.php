<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing authors with pivot data
        $authors = $this->record->authors()->get()->map(function ($author) {
            return [
                'author_id' => $author->id,
                'author_order' => $author->pivot->author_order,
                'is_corresponding' => $author->pivot->is_corresponding,
                'affiliation_at_time' => $author->pivot->affiliation_at_time,
                'contribution' => $author->pivot->contribution,
            ];
        })->toArray();

        $data['authors'] = $authors;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove authors from the main data array - they will be handled separately
        if (isset($data['authors'])) {
            unset($data['authors']);
        }
        
        return $data;
    }

    protected function afterSave(): void
    {
        // Get the form data
        $data = $this->form->getState();
        
        // Handle authors relationship
        if (isset($data['authors']) && is_array($data['authors'])) {
            $authorsToSync = [];
            
            foreach ($data['authors'] as $authorData) {
                if (isset($authorData['author_id'])) {
                    $authorsToSync[$authorData['author_id']] = [
                        'author_order' => $authorData['author_order'] ?? 1,
                        'is_corresponding' => $authorData['is_corresponding'] ?? false,
                        'affiliation_at_time' => $authorData['affiliation_at_time'] ?? null,
                        'contribution' => $authorData['contribution'] ?? null,
                    ];
                }
            }
            
            // Sync authors to the article (this will add/update/remove as needed)
            $this->record->authors()->sync($authorsToSync);
        } else {
            // If no authors provided, detach all
            $this->record->authors()->detach();
        }
    }
}