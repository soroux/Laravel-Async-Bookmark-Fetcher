<?php

use App\Http\Controllers\Api\V1\BookmarkController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api_auth'])->group(function () {
    Route::prefix('bookmarks')->group(function () {
        Route::get('/', [BookmarkController::class, 'index']);
        Route::post('/', [BookmarkController::class, 'store']);
        Route::delete('/{bookmark}', [BookmarkController::class, 'delete']);
    });
});
