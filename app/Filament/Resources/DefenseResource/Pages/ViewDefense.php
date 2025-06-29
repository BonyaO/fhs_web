<?php

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
                Section::make('Defense Details')
                    ->schema([
                        TextEntry::make('date')
                            ->label('Date')
                            ->date('d/m/Y'),
                        TextEntry::make('time')
                            ->label('Time')
                            ->time('H:i'),
                        TextEntry::make('venue')
                            ->label('Venue'),
                        TextEntry::make('jury_number')
                            ->label('Jury Number'),
                    ])->columns(2),

                Section::make('Student Information')
                    ->schema([
                        ImageEntry::make('student_photo')
                            ->label('Photo')
                            ->circular()
                            ->size(100),
                        TextEntry::make('student_name')
                            ->label('Student Name'),
                        TextEntry::make('registration_number')
                            ->label('Registration Number'),
                        TextEntry::make('thesis_title')
                            ->label('Thesis Title')
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('Jury Members')
                    ->schema([
                        TextEntry::make('president_info')
                            ->label('President'),
                        TextEntry::make('rapporteur_info')
                            ->label('Rapporteur'),
                        TextEntry::make('jury_members')
                            ->label('Members')
                            ->getStateUsing(function ($record) {
                                $members = $record->jury_members;
                                
                                // Handle empty case
                                if (empty($members)) {
                                    return 'No members found';
                                }
                                
                                // Handle JSON string
                                if (is_string($members)) {
                                    $decoded = json_decode($members, true);
                                    if (json_last_error() === JSON_ERROR_NONE) {
                                        $members = $decoded;
                                    } else {
                                        return 'Invalid data format';
                                    }
                                }
                                
                                // Handle non-array
                                if (!is_array($members)) {
                                    return 'Invalid data format';
                                }
                                
                                // Process members
                                $formatted = [];
                                foreach ($members as $member) {
                                    if (!is_array($member)) continue;
                                    
                                    $title = isset($member['title']) && !empty($member['title']) 
                                        ? $member['title'] . ' ' 
                                        : '';
                                    $name = $member['name'] ?? '';
                                    
                                    if (!empty($name)) {
                                        $formatted[] = trim($title . $name);
                                    }
                                }
                                
                                return empty($formatted) ? 'No valid members found' : implode(', ', $formatted);
                            })
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Additional Information')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->colors([
                                'scheduled' => 'warning',
                                'in_progress' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                            ])
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'scheduled' => 'Scheduled',
                                'in_progress' => 'In Progress',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            }),
                        TextEntry::make('notes')
                            ->label('Notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}