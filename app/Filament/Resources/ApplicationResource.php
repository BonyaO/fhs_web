<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Models\Application;
use App\Models\DepartmentOption;
use App\Models\Division;
use App\Models\QualificationType;
use App\Models\Region;
use App\Models\SubDivision;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    // TAB1: FINANCE
                    Wizard\Step::make('Bank receipts')
                        ->schema([
                            Forms\Components\TextInput::make('bankref')
                                ->label('Bank transaction ref number')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\FileUpload::make('bankrecipt')
                                ->label('Upload your bank payment receipt')
                                ->hint('Should not exceed 500kb')
                                ->helperText('Only PDF allowed')
                                ->preserveFilenames(true)
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->maxSize(500),
                        ])->columns(2),

                    // TAB2: PERSONAL
                    Wizard\Step::make('Personal Information')
                        ->schema([
                            Forms\Components\TextInput::make('fullname')
                                ->label('Full name (As on Birth Certificate)')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required(),
                            Forms\Components\TextInput::make('telephone')
                                ->tel()
                                ->required(),
                            Forms\Components\TextInput::make('country')
                                ->required()
                                ->maxLength(255)
                                ->default('Cameroon'),

                            Forms\Components\Select::make('region_id')
                                ->label('Region of origin')
                                ->native(false)
                                ->searchable()
                                ->options(Region::all()->pluck('name')),

                            Forms\Components\Select::make('division_id')
                                ->label('Division of origin')
                                ->native(false)
                                ->searchable()
                                ->options(Division::all()->pluck('name')),

                            Forms\Components\Select::make('sub_division_id')
                                ->label('Sub-division of origin')
                                ->native(false)
                                ->searchable()
                                ->options(SubDivision::all()->pluck('name')),

                            Forms\Components\TextInput::make('idc_number')
                                ->label('ID Card number')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\Select::make('gender')
                                ->options([
                                    'male' => 'Male',
                                    'female' => 'Female',
                                ])
                                ->required()
                                ->native(false)
                                ->default('male'),

                            Forms\Components\FileUpload::make('passport')
                                ->label('Upload your 4x4 passport photograph')
                                ->hint('Should not exceed 500kb')
                                ->image()
                                ->preserveFilenames(true)
                                ->maxSize(500)
                                ->required(),

                            Forms\Components\FileUpload::make('birthcert')
                                ->label('Upload your birth certificate')
                                ->hint('Should not exceed 500kb')
                                ->acceptedFileTypes(['application/pdf'])
                                ->preserveFilenames(true)
                                ->maxSize(500)
                                ->required(),

                            Forms\Components\Select::make('marital_status')
                                ->required()
                                ->native(false)
                                ->options([
                                    'single' => 'Single',
                                    'married' => 'Married',
                                    'divorced' => 'Divorced',
                                    'widowed' => 'Widowed',
                                ]),

                            Forms\Components\Toggle::make('is_civil_servant')->label('Are you a civil servant?')
                                ->required(),
                        ])->columns(2),

                    // TAB3: GUARDIAN
                    Wizard\Step::make('Guardian Information')
                        ->schema([
                            Fieldset::make('Mother')->schema([
                                Forms\Components\TextInput::make('mother_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mother_address')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mother_contact')
                                    ->tel()
                                    ->maxLength(255),
                            ]),
                            Fieldset::make('Father')->schema([
                                Forms\Components\TextInput::make('father_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('father_address')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('father_contact')
                                    ->maxLength(255),
                            ]),
                            Fieldset::make('Guardian')->schema([
                                Forms\Components\TextInput::make('guardian_name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('guardian_address')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('guardian_contact')
                                    ->maxLength(255),
                            ]),
                        ])->columns(2),

                    // TAB4: Programme information
                    Wizard\Step::make('Degree Programme')->schema([
                        Forms\Components\Select::make('option1')
                            ->label('First choice')
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->options(DepartmentOption::all()->pluck('name')),
                        Forms\Components\Select::make('option2')
                            ->label('Second choice')
                            ->native(false)
                            ->searchable()
                            ->options(DepartmentOption::all()->pluck('name')),
                        Forms\Components\Select::make('option3')
                            ->label('Third choice')
                            ->native(false)
                            ->searchable()
                            ->options(DepartmentOption::all()->pluck('name')),
                        Forms\Components\Select::make('exam_center_id')
                            ->label('Choose your examination center')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->relationship('examCenter', 'name'),
                        Forms\Components\Radio::make('primary_language')
                            ->label('What is your primary language?')
                            ->options([
                                'en' => 'English',
                                'fr' => 'French',
                            ]),
                    ])->columns(2),

                    Wizard\Step::make('Qualifications')->schema([
                        Fieldset::make('')->label('Maths and English check')
                            ->schema([
                                Forms\Components\Radio::make('has_math')
                                    ->required()
                                    ->options([
                                        'yes' => 'Yes',
                                        'no' => 'No',
                                    ])
                                    ->label('Do you have a pass in Maths at the ordinary level'),
                                Forms\Components\Radio::make('has_english')
                                    ->required()
                                    ->options([
                                        'yes' => 'Yes',
                                        'no' => 'No',
                                    ])
                                    ->label('Do you have a pass in English at the ordinary level'),
                            ]),
                        Repeater::make('Secondary school certifcates')
                            ->relationship('qualifications')
                            ->label('Secondary school certifcates')
                            ->maxItems(3)
                            ->minItems(1)
                            // ->hidden(true) // TODO: Hide this based on application level
                            ->schema([
                                Forms\Components\TextInput::make('level')
                                    ->label('Qualification level')
                                    ->default('secondary')
                                    ->disabled()
                                    ->required(),
                                Forms\Components\Select::make('name')
                                    ->required()
                                    ->native(false)
                                    ->options(QualificationType::where('level', 'secondary')
                                        ->pluck('name')),
                                Forms\Components\TextInput::make('school')
                                    ->required(),
                                Forms\Components\TextInput::make('year')->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('points')->numeric()
                                    ->minValue(0)
                                    ->maxValue(33)
                                    ->required(),
                                Forms\Components\FileUpload::make('certificate')
                                    ->required()
                                    ->hint('Max size 500kb')
                                    ->maxSize(500)
                                    ->preserveFilenames(true)
                                    ->acceptedFileTypes(['application/pdf']),
                            ])->columns(2),

                        Repeater::make('High school certifcates')
                            ->label('High school certifcates')
                            ->relationship('qualifications')
                            ->maxItems(3)
                            ->minItems(1)
                            // ->hidden(true) // TODO: Hide this based on application level
                            ->schema([
                                Forms\Components\TextInput::make('level')
                                    ->label('Qualification level')
                                    ->default('high school')
                                    ->disabled()
                                    ->required(),
                                Forms\Components\Select::make('name')
                                    ->native(false)
                                    ->required()
                                    ->options(QualificationType::where('level', 'high school')
                                        ->pluck('name')),
                                Forms\Components\TextInput::make('school')
                                    ->required(),
                                Forms\Components\TextInput::make('year')->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('points')->numeric()
                                    ->minValue(0)
                                    ->maxValue(25)
                                    ->required(),
                                Forms\Components\FileUpload::make('certificate')
                                    ->required()
                                    ->hint('Max size 500kb')
                                    ->maxSize(500)
                                    ->preserveFilenames(true)
                                    ->acceptedFileTypes(['application/pdf']),
                            ])->columns(2),
                    ]),

                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('admitted_on'),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fullname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('idc_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Admit')
                    ->visible(fn (Application $record) => ! isset($record->admitted_on))
                    ->action(function (Application $record) {
                        $record->admitted_on = \Carbon\Carbon::now();
                        $record->save();

                        Notification::make()
                            ->title('Student has been admitted')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exports([
                            ExcelExport::make()->withColumns([
                                Column::make('id')->heading('Number'),
                                Column::make('fullname')->heading('Full Name'),
                                Column::make('dob')->format('d/m/Y')->heading('Date of birth'),
                                Column::make('pob')->heading('Place of birth'),
                                Column::make('gender')->heading('Gender'),
                                Column::make('telephone')->heading('Phone number'),
                                Column::make('email')->heading('Institutional Email'),
                                Column::make('address')->heading('Address'),
                                Column::make('option')->formatStateUsing(fn (string $state) => DepartmentOption::find($state)->name)->heading('First Choice'),
                                Column::make('idc_number')->heading('NID/Passport'),
                                Column::make('country')->heading('Nationality'),
                                Column::make('region.name')->heading('Region of origin'),
                                Column::make('division.name')->heading('Division'),
                                Column::make('sub_division_id')->formatStateUsing(fn (string $state) => SubDivision::find($state)->name)->heading('Sub Division'),
                                Column::make('has_math')->heading('OLevel Maths'),
                                Column::make('has_english')->heading('OLevel English'),
                                Column::make('guardian_name')->heading('Guardian'),
                                Column::make('guardian_address')->heading('Guardian address'),
                                Column::make('guardian_contact')->heading('Guardian Tel'),
                                Column::make('marital_status')->heading('Marital Status'),
                                Column::make('is_civil_servant')->heading('Civil Servant??'),
                            ])
                               // ->modifyQueryUsing(fn ($query) => $query->whereNotNull('admitted_on')),
                        ]),
                ]),
            ]);
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
