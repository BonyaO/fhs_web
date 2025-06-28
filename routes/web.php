<?php

use App\Http\Controllers\CampayController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return redirect('/guest/login');
    return view('welcome');
});

Route::get('/login', function () {
    $level = request()->query('level');
    session(['level' => $level]);

    return redirect('/guest/login');
});

Route::get('webhook', [CampayController::class, 'momoWebhook']);
