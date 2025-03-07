<?php

namespace App\Providers;

use App\Repositories\Bookmark\BookmarkRepository;
use App\Repositories\Bookmark\BookmarkRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BookmarkRepositoryInterface::class, BookmarkRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
