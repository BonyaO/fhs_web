<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use App\Models\Author;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Journal Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Article Details')
                    ->schema([
                        Forms\Components\Select::make('issue_id')
                            ->label('Issue')
                            ->relationship('issue', 'number')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "Vol {$record->volume->number}, Issue {$record->number} ({$record->volume->year})")
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),

                        Forms\Components\Select::make('article_type')
                            ->label('Article Type')
                            ->options([
                                'original_research' => 'Original Research',
                                'review' => 'Review Article',
                                'case_report' => 'Case Report',
                                'editorial' => 'Editorial',
                                'commentary' => 'Commentary',
                                'short_communication' => 'Short Communication',
                                'letter' => 'Letter to Editor',
                                'systematic_review' => 'Systematic Review',
                                'meta_analysis' => 'Meta-Analysis',
                            ])
                            ->required()
                            ->default('original_research')
                            ->searchable()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(500)
                            ->label('Article Title')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => 
                                $set('slug', Str::slug($state))
                            )
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(500)
                            ->unique(ignoreRecord: true)
                            ->label('URL Slug')
                            ->helperText('Auto-generated from title, but can be customized')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('abstract')
                            ->required()
                            ->label('Abstract')
                            ->helperText('The article abstract (will be displayed online)')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\TagsInput::make('keywords')
                            ->label('Keywords')
                            ->placeholder('Add keywords')
                            ->helperText('Press Enter after each keyword')
                            ->separator(',')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('authors')
                    ->schema([
                        Forms\Components\Repeater::make('authors')
                            ->schema([
                                Forms\Components\Select::make('author_id')
                                    ->label('Author')
                                    ->options(Author::all()->pluck('full_name', 'id'))
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->full_name} ({$record->affiliation})")
                                    ->required()
                                    ->searchable(['first_name', 'surname', 'email'])
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('first_name')
                                            ->required()
                                            ->maxLength(100),
                                        Forms\Components\TextInput::make('surname')
                                            ->required()
                                            ->maxLength(100),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('affiliation')
                                            ->maxLength(500),
                                    ])
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('author_order')
                                    ->label('Order')
                                    ->numeric()
                                    ->default(fn ($get) => $get('../../authors') ? count($get('../../authors')) + 1 : 1)
                                    ->required()
                                    ->minValue(1)
                                    ->columnSpan(1),

                                Forms\Components\Toggle::make('is_corresponding')
                                    ->label('Corresponding Author')
                                    ->default(false)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('affiliation_at_time')
                                    ->label('Affiliation at Publication')
                                    ->helperText('If different from current affiliation')
                                    ->maxLength(500)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('contribution')
                                    ->label('Contribution Statement')
                                    ->helperText('What this author contributed to the research')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(4)
                            ->defaultItems(1)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                Author::find($state['author_id'])?->full_name ?? 'Author'
                            )
                            ->addActionLabel('Add Author')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Publication Details')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('page_start')
                                    ->label('Start Page')
                                    ->numeric()
                                    ->minValue(1)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('page_end')
                                    ->label('End Page')
                                    ->numeric()
                                    ->minValue(1)
                                    ->gte('page_start')
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('doi')
                                    ->label('DOI')
                                    ->helperText('e.g., 10.1234/journal.2024.001')
                                    ->maxLength(255)
                                    ->columnSpan(2),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('submission_date')
                                    ->label('Submission Date')
                                    ->native(false)
                                    ->displayFormat('M d, Y')
                                    ->columnSpan(1),

                                Forms\Components\DatePicker::make('acceptance_date')
                                    ->label('Acceptance Date')
                                    ->native(false)
                                    ->displayFormat('M d, Y')
                                    ->columnSpan(1),

                                Forms\Components\DatePicker::make('publication_date')
                                    ->label('Publication Date')
                                    ->native(false)
                                    ->displayFormat('M d, Y')
                                    ->default(now())
                                    ->columnSpan(1),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('language')
                                    ->label('Language')
                                    ->options([
                                        'en' => 'English',
                                        'fr' => 'French',
                                        'es' => 'Spanish',
                                        'pt' => 'Portuguese',
                                        'de' => 'German',
                                    ])
                                    ->default('en')
                                    ->required()
                                    ->columnSpan(1),

                                Forms\Components\Select::make('license')
                                    ->label('License')
                                    ->options([
                                        'CC-BY-4.0' => 'CC BY 4.0',
                                        'CC-BY-SA-4.0' => 'CC BY-SA 4.0',
                                        'CC-BY-NC-4.0' => 'CC BY-NC 4.0',
                                        'CC-BY-NC-SA-4.0' => 'CC BY-NC-SA 4.0',
                                        'CC-BY-ND-4.0' => 'CC BY-ND 4.0',
                                    ])
                                    ->default('CC-BY-4.0')
                                    ->helperText('Open access license')
                                    ->columnSpan(1),

                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'submitted' => 'Submitted',
                                        'under_review' => 'Under Review',
                                        'revisions_required' => 'Revisions Required',
                                        'accepted' => 'Accepted',
                                        'published' => 'Published',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->default('draft')
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Files')
                    ->schema([
                        Forms\Components\Repeater::make('files')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('file_path')
                                    ->label('File')
                                    ->required()
                                    ->directory('journal/articles')
                                    ->disk('public')
                                    ->acceptedFileTypes([
                                        'application/pdf', 
                                        'application/msword', 
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                                    ])
                                    ->maxSize(10240)
                                    ->helperText('PDF or Word document (max 10MB)')
                                    ->storeFileNamesIn('original_filename')
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        if ($state) {
                                            // Get the uploaded file
                                            $file = is_array($state) ? $state[0] : $state;
                                            
                                            // Set file size and mime type
                                            if ($file instanceof \Illuminate\Http\UploadedFile) {
                                                $set('file_size', $file->getSize());
                                                $set('mime_type', $file->getMimeType());
                                                $set('original_filename', $file->getClientOriginalName());
                                            }
                                        }
                                    })
                                    ->columnSpan(2),

                                Forms\Components\Select::make('file_type')
                                    ->label('Type')
                                    ->options([
                                        'pdf' => 'PDF',
                                        'supplementary' => 'Supplementary Material',
                                        'data' => 'Dataset',
                                        'figures' => 'Figures',
                                    ])
                                    ->default('pdf')
                                    ->required()
                                    ->columnSpan(1),

                                Forms\Components\Toggle::make('is_primary')
                                    ->label('Primary File')
                                    ->default(false)
                                    ->helperText('The main article PDF')
                                    ->columnSpan(1),

                                Forms\Components\Hidden::make('file_size'),
                                Forms\Components\Hidden::make('mime_type'),
                                Forms\Components\Hidden::make('original_filename'),

                                Forms\Components\TextInput::make('version')
                                    ->label('Version')
                                    ->default('1.0')
                                    ->helperText('e.g., 1.0, 1.1, 2.0')
                                    ->columnSpan(1),

                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(4)
                            ->defaultItems(1)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                $state['file_type'] ? ucfirst($state['file_type']) : 'File'
                            )
                            ->addActionLabel('Add File')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Publishing Options')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Make this article visible to the public')
                            ->default(false)
                            ->live()
                            ->columnSpan(1),

                        Forms\Components\Toggle::make('featured')
                            ->label('Featured Article')
                            ->helperText('Display on homepage')
                            ->default(false)
                            ->columnSpan(1),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Published At')
                            ->displayFormat('M d, Y H:i')
                            ->seconds(false)
                            ->hidden(fn (Forms\Get $get) => !$get('is_published'))
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Used for custom sorting within issue')
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->collapsed(),

                Forms\Components\Section::make('Statistics')
                    ->schema([
                        Forms\Components\TextInput::make('view_count')
                            ->label('View Count')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('download_count')
                            ->label('Download Count')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsed()
                    ->hidden(fn (?Article $record) => $record === null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('issue.volume.number')
                    ->label('Vol')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('issue.number')
                    ->label('Issue')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\TextColumn::make('authors.surname')
                    ->label('Authors')
                    ->limit(30)
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->searchable(),

                Tables\Columns\TextColumn::make('article_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => 
                        str_replace('_', ' ', ucwords($state, '_'))
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'original_research' => 'info',
                        'review' => 'warning',
                        'case_report' => 'success',
                        'editorial' => 'danger',
                        default => 'gray',
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('page_range')
                    ->label('Pages')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('publication_date')
                    ->label('Published')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('view_count')
                    ->label('Views')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('download_count')
                    ->label('Downloads')
                    ->badge()
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('issue')
                    ->relationship('issue', 'number')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('article_type')
                    ->label('Article Type')
                    ->options([
                        'original_research' => 'Original Research',
                        'review' => 'Review Article',
                        'case_report' => 'Case Report',
                        'editorial' => 'Editorial',
                        'commentary' => 'Commentary',
                        'short_communication' => 'Short Communication',
                        'letter' => 'Letter to Editor',
                        'systematic_review' => 'Systematic Review',
                        'meta_analysis' => 'Meta-Analysis',
                    ]),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->placeholder('All articles')
                    ->trueLabel('Published only')
                    ->falseLabel('Unpublished only'),

                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Featured')
                    ->placeholder('All articles')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),

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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'abstract', 'keywords', 'doi'];
    }
}