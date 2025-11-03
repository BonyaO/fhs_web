<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Journal Management';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Author Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(100)
                            ->label('First Name')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('surname')
                            ->required()
                            ->maxLength(100)
                            ->label('Surname')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('suffix')
                            ->maxLength(20)
                            ->label('Suffix')
                            ->helperText('e.g., Jr., Sr., III, PhD, MD')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->label('Email Address')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(50)
                            ->label('Phone Number')
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Professional Information')
                    ->schema([
                        Forms\Components\TextInput::make('affiliation')
                            ->maxLength(500)
                            ->label('Primary Affiliation')
                            ->helperText('Institution or organization')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('department')
                            ->maxLength(255)
                            ->label('Department')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('position')
                            ->maxLength(255)
                            ->label('Position/Title')
                            ->columnSpan(1),

                        Forms\Components\Textarea::make('bio')
                            ->label('Biography')
                            ->rows(4)
                            ->maxLength(2000)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('research_interests')
                            ->label('Research Interests')
                            ->rows(3)
                            ->helperText('Separate multiple interests with commas')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Contact & Address')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->maxLength(500)
                            ->label('Address')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('city')
                            ->maxLength(100)
                            ->label('City')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('state')
                            ->maxLength(100)
                            ->label('State/Province')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('postal_code')
                            ->maxLength(20)
                            ->label('Postal Code')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('country')
                            ->maxLength(100)
                            ->label('Country')
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->collapsed(),

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

                        Forms\Components\TextInput::make('researcher_id')
                            ->label('ResearcherID/Publons')
                            ->maxLength(50)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('website')
                            ->url()
                            ->maxLength(255)
                            ->label('Personal Website')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsed(),

                Forms\Components\Section::make('Photo')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Author Photo')
                            ->image()
                            ->directory('journal/authors')
                            ->disk('public')
                            ->imageEditor()
                            ->circleCropper()
                            ->maxSize(2048)
                            ->helperText('Upload a professional photo (max 2MB)')
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png'))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(['first_name', 'surname'])
                    ->sortable(['surname', 'first_name']),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('affiliation')
                    ->label('Affiliation')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('orcid')
                    ->label('ORCID')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('articles_count')
                    ->counts('articles')
                    ->label('Articles')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('country')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_orcid')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('orcid'))
                    ->label('Has ORCID'),

                Tables\Filters\SelectFilter::make('country')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('has_articles')
                    ->query(fn (Builder $query): Builder => $query->has('articles'))
                    ->label('Has Published Articles'),
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
            ->defaultSort('surname', 'asc');
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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'surname', 'email', 'affiliation', 'orcid'];
    }
}