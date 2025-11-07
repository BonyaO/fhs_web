<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove authors from the main data array - they will be handled separately
        if (isset($data['authors'])) {
            unset($data['authors']);
        }
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Get the form data
        $data = $this->form->getState();
        
        // Handle authors relationship
        if (isset($data['authors']) && is_array($data['authors'])) {
            $authorsToAttach = [];
            
            foreach ($data['authors'] as $authorData) {
                if (isset($authorData['author_id'])) {
                    $authorsToAttach[$authorData['author_id']] = [
                        'author_order' => $authorData['author_order'] ?? 1,
                        'is_corresponding' => $authorData['is_corresponding'] ?? false,
                        'affiliation_at_time' => $authorData['affiliation_at_time'] ?? null,
                        'contribution' => $authorData['contribution'] ?? null,
                    ];
                }
            }
            
            // Attach authors to the article
            if (!empty($authorsToAttach)) {
                $this->record->authors()->attach($authorsToAttach);
            }
        }
    }
}
