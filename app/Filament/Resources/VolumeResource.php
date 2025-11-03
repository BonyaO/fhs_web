<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VolumeResource\Pages;
use App\Models\Volume;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VolumeResource extends Resource
{
    protected static ?string $model = Volume::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Journal Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Volume Information')
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label('Volume Number')
                            ->unique(ignoreRecord: true)
                            ->helperText('The volume number (e.g., 1, 2, 3)')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('year')
                            ->required()
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(date('Y') + 1)
                            ->default(date('Y'))
                            ->label('Year')
                            ->helperText('The year this volume was published')
                            ->columnSpan(1),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->helperText('Optional description or theme for this volume')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Whether this volume is visible to the public')
                            ->default(false)
                            ->columnSpan(1),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publication Date')
                            ->helperText('The date this volume was published')
                            ->displayFormat('M d, Y H:i')
                            ->seconds(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('Volume #')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('year')
                    ->label('Year')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('issues_count')
                    ->counts('issues')
                    ->label('Issues')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('articles_count')
                    ->label('Articles')
                    ->getStateUsing(fn (Volume $record) => $record->issues->sum(fn ($issue) => $issue->articles->count()))
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published Date')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->placeholder('All volumes')
                    ->trueLabel('Published only')
                    ->falseLabel('Unpublished only'),

                Tables\Filters\Filter::make('year')
                    ->form([
                        Forms\Components\TextInput::make('year')
                            ->numeric()
                            ->placeholder('Filter by year'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['year'],
                                fn (Builder $query, $year): Builder => $query->where('year', $year),
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
            ->defaultSort('year', 'desc');
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
            'index' => Pages\ListVolumes::route('/'),
            'create' => Pages\CreateVolume::route('/create'),
            'edit' => Pages\EditVolume::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}