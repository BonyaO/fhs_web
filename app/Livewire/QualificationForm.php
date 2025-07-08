<?php

namespace App\Livewire;

use App\Models\Qualification;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class QualificationForm extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Qualification $qualification;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Repeater::make('Your certificate')
                ->label('Register your Secondary and High School Information')
                ->defaultItems(2)
                ->maxItems(2)
                ->minItems(2)
                ->schema([
                    ...$this->formFields(),
                ])->columns(2),
        ])->statePath('data')
            ->model(Qualification::class);
    }

    public function formFields()
    {
        return [
            Forms\Components\TextInput::make('application_id')
                ->default(Auth::user()->application->id ?? '')
                ->hidden(),
            Forms\Components\Select::make('qualification_type_id')
                ->label('Level')
                ->native(false)
                ->relationship('qualificationType', 'name')
                ->required(),
            Forms\Components\TextInput::make('school')
                ->required(),
            Forms\Components\TextInput::make('year')
                ->placeholder('E.g: 2020')
                ->required(),
            Forms\Components\TextInput::make('points')->numeric()
                ->minValue(0)
                ->maxValue(33)
                ->required(),
            Forms\Components\FileUpload::make('certificate')
                ->required()
                ->hint('Max size 500kb')
                ->maxSize(500)
                ->acceptedFileTypes(['application/pdf']),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Qualification::query()->where('application_id', Auth::user()->application?->id))
            ->columns([
                TextColumn::make('school'),
                TextColumn::make('qualificationType.name'),
                TextColumn::make('year'),
                TextColumn::make('points'),
            ])
            ->headerActions([
                \Filament\Tables\Actions\CreateAction::make()
                    ->visible(isset(Auth::user()->application) && !isset(Auth::user()->application->validated_on))
                    ->form($this->formFields())
                    ->mutateFormDataUsing(function (array $data) {
                        $data['application_id'] = Auth::user()->application?->id;
                        return $data;
                    })
                    ->after(function () {
                        // Emit event to refresh parent component
                        $this->dispatch('qualificationAdded');
                        
                        Notification::make()
                            ->title('Qualification added successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make()
                    ->visible(!isset(Auth::user()->application->validated_on))
                    ->form($this->formFields())
                    ->after(function () {
                        // Emit event to refresh parent component
                        $this->dispatch('qualificationAdded');
                        
                        Notification::make()
                            ->title('Qualification updated successfully')
                            ->success()
                            ->send();
                    }),
                \Filament\Tables\Actions\DeleteAction::make()
                    ->visible(!isset(Auth::user()->application->validated_on))
                    ->action(function (Qualification $record) {
                        Storage::delete($record->certificate);
                        $record->delete();
                        
                        // Emit event to refresh parent component
                        $this->dispatch('qualificationAdded');
                        
                        Notification::make()
                            ->title('Record has been removed')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public function render()
    {
        return view('livewire.qualification-form');
    }
}