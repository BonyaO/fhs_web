<?php

// Pages/ViewDefense.php
namespace App\Filament\Resources\DefenseResource\Pages;

use App\Filament\Resources\DefenseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class ViewDefense extends ViewRecord
{
    protected static string $resource = DefenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informations de la soutenance')
                    ->schema([
                        TextEntry::make('date')
                            ->label('Date')
                            ->date('d/m/Y'),
                        TextEntry::make('time')
                            ->label('Heure')
                            ->time('H:i'),
                        TextEntry::make('venue')
                            ->label('Salle'),
                        TextEntry::make('jury_number')
                            ->label('Numéro de Jury'),
                    ])->columns(2),

                Section::make('Informations de l\'étudiant')
                    ->schema([
                        ImageEntry::make('student_photo')
                            ->label('Photo')
                            ->circular()
                            ->size(100),
                        TextEntry::make('student_name')
                            ->label('Nom de l\'étudiant'),
                        TextEntry::make('registration_number')
                            ->label('Numéro d\'inscription'),
                        TextEntry::make('thesis_title')
                            ->label('Titre de la thèse')
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('Composition du Jury')
                    ->schema([
                        TextEntry::make('president_info')
                            ->label('Président'),
                        TextEntry::make('rapporteur_info')
                            ->label('Rapporteur'),
                        TextEntry::make('jury_members')
                            ->label('Autres membres')
                            ->formatStateUsing(function ($state) {
                                if (!$state) return 'Aucun';
                                
                                return collect($state)->map(function ($member) {
                                    $title = $member['title'] ?? '';
                                    $name = $member['name'] ?? '';
                                    return $title ? "$title $name" : $name;
                                })->join(', ');
                            })
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Informations additionnelles')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Statut')
                            ->badge()
                            ->colors([
                                'scheduled' => 'warning',
                                'in_progress' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                            ])
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'scheduled' => 'Programmée',
                                'in_progress' => 'En cours',
                                'completed' => 'Terminée',
                                'cancelled' => 'Annulée',
                            }),
                        TextEntry::make('notes')
                            ->label('Notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}