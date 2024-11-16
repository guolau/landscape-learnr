<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\SettingController;
use App\Http\Controllers\SnippetController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TagCategoryController;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\TagCategory;
use App\Models\Snippet;

Route::get('/', function (Request $request) {
    $tag_category_id = Setting::where('name', 'search_page_dropdown_tag_category_id')->first()->value;
    
    return inertia('Home', [
        'tagCategory' => TagCategory::find($tag_category_id),
        'tags' => Tag::select(['id', 'name'])
            ->whereHas('tagCategory', fn ($query) => $query->where('tag_categories.id', $tag_category_id))
            ->get(),
        'snippets' => Snippet::query()
            ->when($request->tag_id, function ($query, $tag_id) {
                $query->whereHas('tags', fn ($query) => $query->where('tags.id', $tag_id));
            })
            ->when($request->keyword, function ($query, $keyword) {
                $keyword = strtolower($keyword);

                $query->where(function ($query) use ($keyword) {
                    $query->whereHas('tags', function ($query) use ($keyword) {
                        $query->where('name', 'ILIKE', "%{$keyword}%");
                    })
                    ->orWhere('title', 'ILIKE', "%{$keyword}%"); 
                });
            })
            ->with(['images', 'streetViewLinks', 'tags'])
            ->paginate(15)
            ->withQueryString(),
        'filters' => $request->only(['tag_id', 'keyword'])
    ]);
})->name('home');

Route::group(['prefix' => 'settings', 'middleware' => 'admin'], function() {
    Route::get('/', [SettingController::class, 'index'])->name('settings');
    Route::post('/', [SettingController::class, 'update'])->name('settings.update');

});

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

Route::group(['prefix' => 'tags'], function() {
    Route::group(['middleware' => 'can:manage,'.App\Models\Tag::class], function () {
        Route::get('/', [TagController::class, 'index'])->name('tags.index');
        Route::get('/create', [TagController::class, 'create'])->name('tags.create');
        Route::post('/', [TagController::class, 'store'])->name('tags.store');
        Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
        Route::patch('/{tag}', [TagController::class, 'update'])->name('tags.update');
        Route::delete('/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
    });

    Route::get('/{tag}', [TagController::class, 'show'])->name('tags.show');
});

Route::group(['prefix' => 'tag-categories'], function() {
    Route::group(['middleware' => 'can:manage,'.App\Models\Tag::class], function () {
        Route::get('/', [TagCategoryController::class, 'index'])->name('tagCategories.index');
    });
});

require __DIR__.'/auth.php';