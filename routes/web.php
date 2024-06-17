<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers as Controllers;

Route::get('/', function () {
    return inertia('Home');
})->name('home');

Route::resource('snippets', Controllers\SnippetController::class);
