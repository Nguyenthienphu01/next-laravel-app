<?php

/**
 * Class RepositoryServiceProvider.
 * @author PhuNguyen
 * @since 2023-09-07
 */

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

use App\Repositories\AdminRepository;
use App\Repositories\AdminRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @author PhuNguyen
     * @since 2023-09-07
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(AdminRepository::class, AdminRepositoryEloquent::class);
    }
}