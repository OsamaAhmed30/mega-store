<?php
namespace App\Facades;
use App\Repositories\IRepositories\Cart\ICartRepository;
use Illuminate\Support\Facades\Facade;

class Cart extends Facade{
     /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ICartRepository::class;
    }
}