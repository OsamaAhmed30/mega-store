<?php

namespace App\Providers;

use App\Repositories\Cart\CartRepository;
use App\Repositories\IRepositories\Cart\ICartRepository;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ICartRepository::class,function (){
            return new CartRepository();
        });


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
