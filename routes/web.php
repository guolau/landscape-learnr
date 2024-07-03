<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SnippetController;

Route::get('/', function () {
    return inertia('Home');
})->name('home');

Route::group(['prefix' => 'snippets'], function() {
    Route::group(['middleware' => 'can:manage,'.App\Models\Snippet::class], function () {
        Route::get('/', [SnippetController::class, 'index'])->name('snippets.index');
        Route::get('/create', [SnippetController::class, 'create'])->name('snippets.create');
        Route::post('/', [SnippetController::class, 'store'])->name('snippets.store');
        Route::get('/{snippet}/edit', [SnippetController::class, 'edit'])->name('snippets.edit');
        Route::patch('/{snippet}', [SnippetController::class, 'update'])->name('snippets.update');
        Route::delete('/{snippet}', [SnippetController::class, 'destroy'])->name('snippets.destroy');
    });

    Route::get('/{snippet}', [SnippetController::class, 'show'])->name('snippets.show');
});

require __DIR__.'/auth.php';