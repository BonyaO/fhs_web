<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EditorialBoardResource\Pages;
use App\Models\EditorialBoard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EditorialBoardResource extends Resource
{
    protected static ?string $model = EditorialBoard::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Journal Management';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Editorial Board';

    protected static ?string $modelLabel = 'Board Member';

    protected static ?string $pluralModelLabel = 'Editorial Board';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Member Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Full Name')
                            ->columnSpan(2),

                        Forms\Components\Select::make('role')
                            ->label('Board Role')
                            ->options([
                                'editor_in_chief' => 'Editor-in-Chief',
                                'deputy_editor' => 'Deputy Editor',
                                'associate_editor' => 'Associate Editor',
                                'section_editor' => 'Section Editor',
                                'managing_editor' => 'Managing Editor',
                                'editorial_board' => 'Editorial Board Member',
                                'advisory_board' => 'Advisory Board Member',
                                'reviewer' => 'Reviewer',
                            ])
                            ->required()
                            ->searchable()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first')
                            ->columnSpan(1),
                    ])
                    ->columns(4),

                Forms\Components\Section::make('Professional Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->helperText('e.g., Professor, Dr., MD, PhD')
                            ->maxLength(100)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('affiliation')
                            ->label('Institution/Affiliation')
                            ->required()
                            ->maxLength(500)
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('department')
                            ->label('Department')
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('country')
                            ->label('Country')
                            ->maxLength(100)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->label('Email Address')
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('website')
                            ->url()
                            ->label('Personal Website')
                            ->maxLength(255)
                            ->columnSpan(2),

                        Forms\Components\Textarea::make('bio')
                            ->label('Biography')
                            ->rows(4)
                            ->maxLength(2000)
                            ->helperText('Brief professional biography')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('expertise')
                            ->label('Areas of Expertise')
                            ->rows(3)
                            ->helperText('Research interests and areas of expertise')
                            ->columnSpanFull(),
                    ])
                    ->columns(4),

                Forms\Components\Section::make('Academic Identifiers')
                    ->schema([
                        Forms\Components\TextInput::make('orcid')
                            ->label('ORCID')
                            ->maxLength(19)
                            ->helperText('16-digit identifier (e.g., 0000-0002-1825-0097)')
                            ->placeholder('0000-0000-0000-0000')
                            ->mask('9999-9999-9999-9999')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('scopus_id')
                            ->label('Scopus Author ID')
                            ->maxLength(50)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('google_scholar_id')
                            ->label('Google Scholar ID')
                            ->maxLength(50)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('h_index')
                            ->label('h-index')
                            ->numeric()
                            ->helperText('If available')
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->collapsed(),

                Forms\Components\Section::make('Photo')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Profile Photo')
                            ->image()
                            ->directory('journal/editorial-board')
                            ->disk('public')
                            ->imageEditor()
                            ->circleCropper()
                            ->maxSize(2048)
                            ->helperText('Upload a professional photo (max 2MB). Recommended: square aspect ratio')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Status & Dates')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Member')
                            ->helperText('Whether this member is currently active on the board')
                            ->default(true)
                            ->columnSpan(1),

                        Forms\Components\DatePicker::make('start_date')
                            ->label('Start Date')
                            ->native(false)
                            ->displayFormat('M d, Y')
                            ->helperText('When this member joined the board')
                            ->columnSpan(1),

                        Forms\Components\DatePicker::make('end_date')
                            ->label('End Date')
                            ->native(false)
                            ->displayFormat('M d, Y')
                            ->helperText('Leave empty if currently active')
                            ->columnSpan(1),
                    ])
                    ->columns(3)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png'))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => 
                        str_replace('_', ' ', ucwords($state, '_'))
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'editor_in_chief' => 'danger',
                        'deputy_editor' => 'warning',
                        'associate_editor' => 'success',
                        'managing_editor' => 'info',
                        'section_editor' => 'primary',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('affiliation')
                    ->label('Affiliation')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(fn (EditorialBoard $record): ?string => $record->affiliation),

                Tables\Columns\TextColumn::make('country')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Since')
                    ->date('M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'editor_in_chief' => 'Editor-in-Chief',
                        'deputy_editor' => 'Deputy Editor',
                        'associate_editor' => 'Associate Editor',
                        'section_editor' => 'Section Editor',
                        'managing_editor' => 'Managing Editor',
                        'editorial_board' => 'Editorial Board Member',
                        'advisory_board' => 'Advisory Board Member',
                        'reviewer' => 'Reviewer',
                    ])
                    ->label('Board Role'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All members')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\SelectFilter::make('country')
                    ->searchable()
                    ->preload(),
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
            ->defaultSort('order', 'asc')
            ->reorderable('order');
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
            'index' => Pages\ListEditorialBoards::route('/'),
            'create' => Pages\CreateEditorialBoard::route('/create'),
            'edit' => Pages\EditEditorialBoard::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'affiliation', 'email'];
    }
}