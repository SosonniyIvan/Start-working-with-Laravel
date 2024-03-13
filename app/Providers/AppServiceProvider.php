<?php

namespace App\Providers;

use App\Repositories\Contract\ImageRepositoryInterface;
use App\Repositories\Contract\ProductsRepositoryInterface;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use App\Services\Contract\FileStorageServiceInterface;
use App\Services\FileStorageService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        FileStorageServiceInterface::class => FileStorageService::class,
        ProductsRepositoryInterface::class => ProductRepository::class,
        ImageRepositoryInterface::class => ImageRepository::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
