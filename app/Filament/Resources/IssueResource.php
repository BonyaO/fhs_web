<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IssueResource\Pages;
use App\Models\Issue;
use App\Models\Volume;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class IssueResource extends Resource
{
    protected static ?string $model = Issue::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Journal Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Issue Information')
                    ->schema([
                        Forms\Components\Select::make('volume_id')
                            ->label('Volume')
                            ->relationship('volume', 'number')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('number')
                                    ->required()
                                    ->numeric()
                                    ->label('Volume Number'),
                                Forms\Components\TextInput::make('year')
                                    ->required()
                                    ->numeric()
                                    ->default(date('Y')),
                                Forms\Components\Toggle::make('is_published')
                                    ->label('Published')
                                    ->default(false),
                            ])
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('number')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label('Issue Number')
                            ->helperText('The issue number within the volume (e.g., 1, 2, 3)')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('title')
                            ->label('Issue Title')
                            ->helperText('Optional title or theme for this issue')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->helperText('Optional description for this issue')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('publication_date')
                            ->label('Publication Date')
                            ->required()
                            ->default(now())
                            ->displayFormat('M d, Y')
                            ->native(false)
                            ->columnSpan(1),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Whether this issue is visible to the public')
                            ->default(false)
                            ->live()
                            ->columnSpan(1),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Published At')
                            ->helperText('Automatically set when published')
                            ->displayFormat('M d, Y H:i')
                            ->seconds(false)
                            ->hidden(fn (Forms\Get $get) => !$get('is_published'))
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->helperText('Leave blank to auto-generate')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Issue Cover')
                    ->schema([
                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Cover Image')
                            ->image()
                            ->directory('journal/covers')
                            ->disk('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '8.5:11',
                                '210:297', // A4
                            ])
                            ->maxSize(5120)
                            ->helperText('Upload a cover image for this issue (max 5MB). Recommended ratio: 8.5x11 or A4')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\TextInput::make('doi')
                            ->label('DOI')
                            ->helperText('Digital Object Identifier for this issue')
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Used for custom sorting')
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('volume.number')
                    ->label('Volume')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('number')
                    ->label('Issue #')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(),

                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->disk('public')
                    ->circular()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('articles_count')
                    ->counts('articles')
                    ->label('Articles')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('publication_date')
                    ->label('Publication Date')
                    ->date('M d, Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('volume')
                    ->relationship('volume', 'number')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->placeholder('All issues')
                    ->trueLabel('Published only')
                    ->falseLabel('Unpublished only'),

                Tables\Filters\Filter::make('publication_date')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->label('Published from')
                            ->native(false),
                        Forms\Components\DatePicker::make('published_until')
                            ->label('Published until')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('publication_date', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('publication_date', '<=', $date),
                            );
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
            ->defaultSort('publication_date', 'desc');
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
            'index' => Pages\ListIssues::route('/'),
            'create' => Pages\CreateIssue::route('/create'),
            'edit' => Pages\EditIssue::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}