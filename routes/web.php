<?php

use App\Http\Controllers\{
    HomeController,
    CategoryController,
    CollectionController,
    TagController,
    SearchController,
    UserController,
    BoxController,
    PageController
};


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class);

require __DIR__ . '/management.php';
require __DIR__ . '/dashboard.php';

Route::get('/@{user}', [UserController::class, 'show'])->name('users.profile');
Route::get('/@{user}/boxes', [BoxController::class, 'index'])->name('users.boxes');
Route::get('/@{user}/boxes/{box}', [BoxController::class, 'show'])->name('users.boxes.show');

Route::controller('\App\Http\Controllers\ArticleController')->group(function () {
    Route::get('articles/{article}', 'show')->name('articles.show');
    Route::get('articles', 'index')->name('articles.index');
    Route::get('articles/by-title/{search}', 'titleSearch');
});

Route::get('collections/{collection}', [CollectionController::class, 'show'])->name('collections.show');
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('tags/{tag}', [TagController::class, 'show'])->name('tags.show');

Route::controller(SearchController::class)->name('search.')->group(function () {
    Route::get('search/people', 'people')->name('people');
    Route::get('search/topics', 'topics')->name('topic');
    Route::get('search', 'article')->name('article');
});

require __DIR__ . '/auth.php';

Route::controller(PageController::class)->group(function () {
    Route::get('/about', 'about');
    Route::get('/policy', 'policy');
    Route::get('/contact', 'contact');
    Route::get('/terms', 'terms');
});

