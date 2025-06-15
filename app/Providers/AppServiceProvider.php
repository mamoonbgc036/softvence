<?php

namespace App\Providers;

use App\Repositories\CourseRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\CourseRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
