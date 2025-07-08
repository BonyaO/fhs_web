<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ApplicationProgress extends Component
{
    public $steps = [
        'payment' => 'Payment Completed',
        'application' => 'Application Form Filled',
        'qualifications' => 'Qualifications Uploaded',
        'validation' => 'Application Validated'
    ];

    protected $listeners = ['qualificationAdded' => '$refresh'];

    public function getStepStatus($step)
    {
        $user = Auth::user();
        
        switch ($step) {
            case 'payment':
                return $user->payment && $user->payment->status === 'SUCCESSFUL';
            case 'application':
                return $user->application !== null;
            case 'qualifications':
                return $user->application && $user->application->qualifications()->count() > 0;
            case 'validation':
                return $user->application && $user->application->validated_on !== null;
            default:
                return false;
        }
    }

    public function canValidate()
    {
        return $this->getStepStatus('payment') && 
               $this->getStepStatus('application') && 
               $this->getStepStatus('qualifications') && 
               !$this->getStepStatus('validation');
    }

    public function render()
    {
        return view('livewire.application-progress');
    }
}