<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\DepartmentOption;
use App\Models\Division;
use App\Models\Region;
use App\Models\SubDivision;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Livewire\Component;

class ApplicationForm extends Component implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

    public Application $application;

    public $isEdit = false;

    public ?array $createData = [];

    public ?array $editData = [];

    public function downloadForm()
    {
        return response()->streamDownload(function () {
            echo Pdf::loadHtml(
                Blade::render('reports.student-form', [
                    'student' => Auth::user()->application,
                    'qualifications' => Auth::user()->application->qualifications,
                ])
            )->stream();
        }, 'FHS-'.Auth::user()->application->full_name.'.pdf');
    }

    public function toggleEdit()
    {
        $this->isEdit = true;
        redirect('/guest/submit-application?edit=true');
    }

    /**
     * @throws BindingResolutionException
     */
    public function mount(): void
    {
        if (request()->query('edit')) {
            $this->isEdit = request()->query('edit');
            $this->editForm->fill(auth()->user()->application->toArray());
        } else {
            $this->createForm->fill();
        }
    }

    protected function getForms(): array
    {
        return [
            'editForm',
            'createForm',
        ];
    }

    public function createForm(Form $form): Form
    {
        return $form->schema($this->formFields())
            ->statePath('createData')
            ->model(Application::class);
    }

    public function editForm(Form $form): Form
    {
        return $form->schema($this->formFields())
            ->statePath('editData')
            ->model(auth()->user()->application);
    }

    protected function formFields()
    {
        return [
            Forms\Components\Wizard::make([
                // TAB1: FINANCE
                Wizard\Step::make('Bank receipts')
                    ->schema([
                        Forms\Components\TextInput::make('bankref')
                            ->label('Bank transaction ref number')
                            ->unique($this->isEdit ? false : Application::class)
                            ->required(fn () => ! $this->isEdit)
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('bankrecipt')
                            ->label('Upload your bank payment receipt')
                            ->hint('Should not exceed 500kb')
                            ->helperText('Only PDF allowed')
                            // ->preserveFilenames(true)
                            ->acceptedFileTypes(['application/pdf'])
                            ->required()
                            ->maxSize(500),
                    ])->columns(2),

                // TAB2: PERSONAL
                Wizard\Step::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')
                            ->label('Full name (As on Birth Certificate)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('dob')
                            ->native(false)
                            ->label('Date of birth')
                            ->required()
                            ->date(),
                        Forms\Components\TextInput::make('pob')
                            ->label('Place of birth')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->default(auth()->user()->email)
                            ->disabled()
                            ->email()
                            ->unique($this->isEdit ? false : Application::class)
                            ->required(),
                        Forms\Components\TextInput::make('telephone')
                            ->tel()
                            ->required(),
                        Forms\Components\TextInput::make('country')
                            ->required()
                            ->live()
                            ->maxLength(255)
                            ->default('Cameroon'),

                        Forms\Components\Select::make('region_id')
                            ->label('Region of origin')
                            ->native(false)
                            ->searchable()
                            ->live()
                            ->hidden(fn (Get $get) => $get('country') != 'Cameroon')
                            ->options(Region::all()->pluck('name', 'id')),

                        Forms\Components\Select::make('division_id')
                            ->label('Division of origin')
                            ->native(false)
                            ->searchable()
                            ->live()
                            ->options(fn (Get $get) => Division::query('region_id', $get('region_id'))->pluck('name', 'id')),

                        Forms\Components\Select::make('sub_division_id')
                            ->label('Sub-division of origin')
                            ->native(false)
                            ->searchable()
                            ->options(fn (Get $get) => SubDivision::query('division_id', $get('division_id'))->pluck('name', 'id')),

                        Forms\Components\TextInput::make('idc_number')
                            ->label('ID Card number')
                            ->required()
                            ->unique($this->isEdit ? false : Application::class)
                            ->maxLength(255),

                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->required()
                            ->native(false)
                            ->default('male'),

                        Forms\Components\Select::make('marital_status')
                            ->required()
                            ->native(false)
                            ->options([
                                'single' => 'Single',
                                'married' => 'Married',
                                'divorced' => 'Divorced',
                                'widowed' => 'Widowed',
                            ]),
                        Forms\Components\ToggleButtons::make('is_civil_servant')
                            ->boolean()
                            ->label('Are you a civil servant?')
                            ->required(),

                        Forms\Components\FileUpload::make('passport')
                            ->label('Upload your 4x4 passport photograph')
                            ->hint('Should not exceed 500kb')
                            ->image()
                            ->maxSize(500)
                            ->required(),

                        Forms\Components\FileUpload::make('birthcert')
                            ->label('Upload your birth certificate')
                            ->hint('Should not exceed 500kb')
                            ->acceptedFileTypes(['application/pdf'])
                            // ->preserveFilenames(true)
                            ->maxSize(500)
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
                    Forms\Components\Select::make('option')
                        ->label('Select your option')
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->options(DepartmentOption::all()->pluck('name', 'id')),
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
                                ->label('Do you have a pass in Maths at the ordinary level')
                                ->required()
                                ->options([
                                    'yes' => 'Yes',
                                    'no' => 'No',
                                ]),
                            Forms\Components\Radio::make('has_english')
                                ->label('Do you have a pass in English at the ordinary level')
                                ->required()
                                ->options([
                                    'yes' => 'Yes',
                                    'no' => 'No',
                                ]),
                        ]),
                ]),
            ])->columnSpanFull(),
        ];
    }

    public function applicationInfoList(Infolist $infolist)
    {
        return $infolist
            ->record(auth()->user()->application)
            ->schema([
                Tabs::make('Tabs')->tabs([
                    Tabs\Tab::make('personal information')
                        ->schema([
                            TextEntry::make('full_name')->label('Full Name'),
                            TextEntry::make('user.email')->label('Email'),
                            TextEntry::make('address'),
                            TextEntry::make('telephone'),
                            TextEntry::make('marital_status'),
                            TextEntry::make('country'),
                            TextEntry::make('region.name'),
                            TextEntry::make('division.name'),
                            TextEntry::make('subDivision.name'),
                        ])->columns(3),
                    Tabs\Tab::make('Guardian information')
                        ->schema([
                            TextEntry::make('father_name'),
                            TextEntry::make('father_contact'),
                            TextEntry::make('father_address'),
                            TextEntry::make('mother_name'),
                            TextEntry::make('mother_contact'),
                            TextEntry::make('mother_address'),
                            TextEntry::make('guardian_name'),
                            TextEntry::make('guardian_contact'),
                            TextEntry::make('guardian_address'),
                        ])->columns(3),
                ]),
            ]);
    }

    public function create(): void
    {
        Application::create([
            ...$this->createForm->getState(),
            'user_id' => Auth::id(),
            'email' => Auth::user()->email,
        ]);

        Notification::make('Hurray!')
            ->body('Your application has been submitted successfully')
            ->success()
            ->send();

        redirect('/guest/submit-application');
    }

    public function edit(): void
    {
        auth()->user()->application->update([
            ...$this->editForm->getState(),
        ]);

        $this->toggleEdit();

        Notification::make('Hurray!')
            ->body('Your application has been updated successfully')
            ->success()
            ->send();
        redirect('/guest/submit-application');
    }

    public function render()
    {
        return view('livewire.application-form');
    }
}
