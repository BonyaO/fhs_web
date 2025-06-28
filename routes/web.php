<?php

use App\Http\Controllers\CampayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DefenseController;

Route::get('/', function () {
    // return redirect('/guest/login');
    return view('welcome');
});

Route::get('/login', function () {
    $level = request()->query('level');
    session(['level' => $level]);

    return redirect('/guest/login');
});

// Defense routes (public access)
Route::get('/defenses', [DefenseController::class, 'index'])->name('defenses.index');
Route::get('/defenses/{defense}', [DefenseController::class, 'show'])->name('defenses.show');

// downloadable PDF route
Route::get('/defenses/{defense}/pdf', [DefenseController::class, 'downloadPDF'])->name('defenses.pdf');

Route::get('webhook', [CampayController::class, 'momoWebhook']);
