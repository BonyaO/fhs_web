<?php

namespace App\Filament\Pages;

use App\Models\JournalSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Actions\Action; // IMPORTANT: Use this import

class JournalSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Journal Management';

    protected static ?int $navigationSort = 6;

    protected static string $view = 'filament.pages.journal-settings-page';

    protected static ?string $navigationLabel = 'Journal Settings';

    protected static ?string $title = 'Journal Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = JournalSettings::first();
        $this->form->fill($settings ? $settings->toArray() : []);
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Journal Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General Information')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make('Journal Identity')
                                    ->schema([
                                        Forms\Components\TextInput::make('journal_name')
                                            ->label('Journal Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->default('African Annals of Health Sciences')
                                            ->columnSpan(2),

                                        Forms\Components\TextInput::make('journal_acronym')
                                            ->label('Journal Acronym')
                                            ->helperText('e.g., AAHS')
                                            ->maxLength(20)
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('publisher')
                                            ->label('Publisher')
                                            ->maxLength(255)
                                            ->default('University of Bamenda')
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('tagline')
                                            ->label('Tagline')
                                            ->helperText('Brief catchphrase for the journal')
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('description')
                                            ->label('Journal Description/Scope')
                                            ->helperText('Aims and scope of the journal')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'bulletList',
                                                'orderedList',
                                                'h2',
                                                'h3',
                                                'link',
                                            ])
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(4),

                                Forms\Components\Section::make('ISSN & Publication')
                                    ->schema([
                                        Forms\Components\TextInput::make('issn_print')
                                            ->label('ISSN (Print)')
                                            ->helperText('Format: 1234-5678')
                                            ->mask('9999-9999')
                                            ->placeholder('0000-0000')
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('issn_online')
                                            ->label('ISSN (Online)')
                                            ->helperText('Format: 1234-5678')
                                            ->mask('9999-9999')
                                            ->placeholder('0000-0000')
                                            ->columnSpan(1),

                                        Forms\Components\Select::make('publication_frequency')
                                            ->label('Publication Frequency')
                                            ->options([
                                                'Monthly' => 'Monthly',
                                                'Bimonthly' => 'Bimonthly',
                                                'Quarterly' => 'Quarterly',
                                                'Biannual' => 'Biannual (Twice a year)',
                                                'Annual' => 'Annual',
                                            ])
                                            ->default('Biannual')
                                            ->columnSpan(1),

                                        Forms\Components\Textarea::make('indexing_info')
                                            ->label('Indexing Information')
                                            ->helperText('List databases where the journal is indexed (one per line)')
                                            ->rows(3)
                                            ->columnSpan(1),
                                    ])
                                    ->columns(4),

                                Forms\Components\Section::make('Visual Identity')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo')
                                            ->label('Journal Logo')
                                            ->image()
                                            ->directory('journal/assets')
                                            ->disk('public')
                                            ->imageEditor()
                                            ->maxSize(2048)
                                            ->helperText('Upload journal logo (max 2MB)')
                                            ->columnSpan(1),

                                        Forms\Components\FileUpload::make('cover_default')
                                            ->label('Default Issue Cover')
                                            ->image()
                                            ->directory('journal/assets')
                                            ->disk('public')
                                            ->imageEditor()
                                            ->maxSize(5120)
                                            ->helperText('Default cover image for issues without a custom cover')
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Contact Information')
                            ->icon('heroicon-o-envelope')
                            ->schema([
                                Forms\Components\Section::make('Email Addresses')
                                    ->schema([
                                        Forms\Components\TextInput::make('contact_email')
                                            ->label('General Contact Email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('submission_email')
                                            ->label('Manuscript Submission Email')
                                            ->email()
                                            ->maxLength(255)
                                            ->helperText('Email for manuscript submissions')
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Social Media')
                                    ->schema([
                                        Forms\Components\TextInput::make('twitter')
                                            ->label('Twitter/X Handle')
                                            ->prefix('@')
                                            ->maxLength(255)
                                            ->helperText('Without the @ symbol')
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('facebook')
                                            ->label('Facebook Page URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('linkedin')
                                            ->label('LinkedIn Page URL')
                                            ->url()
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                    ])
                                    ->columns(3),
                            ]),

                        Forms\Components\Tabs\Tab::make('Policies')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Forms\Components\Section::make('Copyright & Access')
                                    ->schema([
                                        Forms\Components\RichEditor::make('copyright_policy')
                                            ->label('Copyright Policy')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                            ])
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('open_access_statement')
                                            ->label('Open Access Statement')
                                            ->helperText('Statement about open access and licensing')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Forms\Components\Section::make('Editorial Policies')
                                    ->schema([
                                        Forms\Components\RichEditor::make('ethical_guidelines')
                                            ->label('Ethical Guidelines')
                                            ->helperText('Publication ethics and malpractice statement')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                            ])
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('peer_review_policy')
                                            ->label('Peer Review Policy')
                                            ->helperText('Description of the peer review process')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Author Guidelines')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Section::make('Submission Information')
                                    ->schema([
                                        Forms\Components\RichEditor::make('submission_guidelines')
                                            ->label('Submission Guidelines')
                                            ->helperText('Instructions for authors on how to submit manuscripts')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                                'h2',
                                                'h3',
                                                'link',
                                            ])
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('manuscript_preparation')
                                            ->label('Manuscript Preparation Guidelines')
                                            ->helperText('Formatting, structure, and style requirements')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                                'h2',
                                                'h3',
                                                'link',
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $settings = JournalSettings::first();

            if ($settings) {
                $settings->update($data);
            } else {
                JournalSettings::create($data);
            }

            Notification::make()
                ->success()
                ->title('Settings saved successfully')
                ->body('Journal settings have been updated.')
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Error saving settings')
                ->body('There was an error saving the journal settings: ' . $e->getMessage())
                ->send();
        }
    }

     protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save')
                ->icon('heroicon-o-check'),
        ];
    }
}
