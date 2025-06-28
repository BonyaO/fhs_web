<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DefenseResource\Pages;
use App\Models\Defense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;

class DefenseResource extends Resource
{
    protected static ?string $model = Defense::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Defenses';

    protected static ?string $pluralModelLabel = 'Defenses';

    protected static ?string $modelLabel = 'Defense';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Defense Details')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Date')
                            ->required()
                            ->native(false),
                        Forms\Components\TimePicker::make('time')
                            ->label('Time')
                            ->required()
                            ->seconds(false),
                        Forms\Components\TextInput::make('venue')
                            ->label('Venue')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jury_number')
                            ->label('Jury Number')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Student Information')
                    ->schema([
                        Forms\Components\TextInput::make('student_name')
                            ->label('Student Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('registration_number')
                            ->label('Registration Number')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('thesis_title')
                            ->label('Thesis Title')
                            ->required()
                            ->rows(3),
                        Forms\Components\FileUpload::make('student_photo')
                            ->label('Student Photo')
                            ->image()
                            ->directory('student-photos')
                            ->visibility('public'),
                    ])->columns(2),

                Section::make('Jury Members')
                    ->schema([
                        Forms\Components\TextInput::make('president_name')
                            ->label('President Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('president_title')
                            ->label('President Title')
                            ->maxLength(255)
                            ->placeholder('Ex: Pr, Dr, etc.'),
                        Forms\Components\TextInput::make('rapporteur_name')
                            ->label('Rapporteur Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('rapporteur_title')
                            ->label('Rapporteur Title')
                            ->maxLength(255)
                            ->placeholder('Ex: Pr, Dr, etc.'),
                    ])->columns(2),

                Section::make('Other Jury Members')
                    ->schema([
                        Repeater::make('jury_members')
                            ->label('Additional Members')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Name')
                                    ->required(),
                                Forms\Components\TextInput::make('title')
                                    ->label('Title')
                                    ->placeholder('Ex: Pr, Dr, etc.'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add Member')
                            ->defaultItems(0)
                            ->collapsible(),
                    ]),

                Section::make('Other Information')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'scheduled' => 'Scheduled',
                                'in_progress' => 'In Progress',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('scheduled')
                            ->required(),
                        Forms\Components\Textarea::make('remarks')
                            ->label('Remarks')
                            ->rows(3),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')
                    ->label('Time')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('venue')
                    ->label('Venue')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jury_number')
                    ->label('Jury N°')
                    ->searchable(),
                Tables\Columns\TextColumn::make('student_name')
                    ->label('Student')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('registration_number')
                    ->label('Registration No.')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('student_photo')
                    ->label('Photo')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('thesis_title')
                    ->label('Title')
                    ->limit(50)
                    ->tooltip(function (Defense $record): ?string {
                        return $record->thesis_title;
                    }),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'warning' => 'scheduled',
                        'primary' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'scheduled' => 'Scheduled',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\Filter::make('date_range')
                    ->label('Period')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('date_to')
                            ->label('To'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['date_from'], fn ($query) => $query->whereDate('date', '>=', $data['date_from']))
                            ->when($data['date_to'], fn ($query) => $query->whereDate('date', '<=', $data['date_to']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDefenses::route('/'),
            'create' => Pages\CreateDefense::route('/create'),
            'view' => Pages\ViewDefense::route('/{record}'),
            'edit' => Pages\EditDefense::route('/{record}/edit'),
        ];
    }
}