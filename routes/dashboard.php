<?php

use App\Http\Controllers\Dashboard\{
    ArticleCommentController,
    ArticleController,
    DashboardController,
    NotificationController,
    BoxController,
    BookmarkController,
    ProfileController
};

use App\Http\Controllers\{
    FollowController,
    LikeController,
};

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('/dashboard')->name('dashboard.')->group(function () {

        Route::get('profiles', [ProfileController::class, 'index'])
            ->name('profiles');

        Route::post('profiles', [ProfileController::class, 'store'])
            ->name('profiles.store');

        Route::resource('articles', ArticleController::class);
        Route::controller(ArticleController::class)->group(function () {
            Route::post('articles/pin/{article}', 'markAsPinned')->name('articles.pin');
            Route::post('user/images', 'contentImage')->name('users.images.store');
        });

        Route::controller(BookmarkController::class)->group(function () {
            Route::post('articles/{article}/bookmark', 'store')->name('articles.bookmark.store');
            Route::get('articles/{article}/bookmark', 'boxes')->name('articles.bookmark.boxes');
            Route::get('bookmarks', 'index')->name('bookmarks.index');
            Route::get('bookmarks/{bookmark}/boxes', 'AllboxesList')->name('bookmark.boxes');
        });

        Route::resource('boxes', BoxController::class);

        Route::get('/notifications/{notification}', [NotificationController::class, 'markIt'])
            ->name('notifications.mark');

        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('notifications.index');

    });

    Route::resource('articles.comments', ArticleCommentController::class);

    Route::post('like/article/{article}', [LikeController::class, 'handleArticle'])
        ->name('likes.handle.article');

    Route::post('like/comment/{comment}', [LikeController::class, 'handleArticleComment'])
        ->name('likes.handle.comment');

    Route::post('follow-user', [FollowController::class, 'storeUser'])->name('follow.store.user');
    Route::post('follow-topic', [FollowController::class, 'storeTopic'])->name('follow.store.topic');
    Route::post('store-interests', [FollowController::class, 'storeInterests'])->name('follow.store.interest');
    Route::post('is-followed', [FollowController::class, 'show'])->name('follow.show');

});
