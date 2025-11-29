<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('people.index');
});

Route::resource('people', PersonController::class);