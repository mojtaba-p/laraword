<?php
use App\Http\Controllers\Management\{
    ArticleController,
    UserController,
    CategoryController,
    CollectionController,
    TagController,
};

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'management'])->group(function(){
    Route::prefix('/management')->name('management.')->group(function(){
        Route::resource('users', UserController::class)->only(['index']);
        Route::post('users/update-role', [UserController::class, 'updateRole'])->name('users.update.role');
        Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::resource('collections', CollectionController::class);
        Route::post('collections/add', [CollectionController::class, 'attachSingleArticle'])
            ->name('collections.add');
        Route::resource('tags', TagController::class);
        Route::resource('categories', CategoryController::class);
    });
});
