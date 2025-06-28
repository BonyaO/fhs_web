<?php

namespace App\Filament\Guest\Pages\Guest;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ProcessPayment extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static string $view = 'filament.guest.pages.guest.process-payment';

    public static function canAccess(): bool
    {
        return ! isset(Auth::user()->payment) || Auth::user()->payment->status !== 'SUCCESSFUL';
    }
}
