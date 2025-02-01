<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ChangeLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //$locale = request('locale',Session::get('locale', config('app.locale')));
        $locale = $request->route('locale');
            
            App::setLocale($locale);
           // Session::put('locale',$locale);

            URL::defaults([
                'locale'=>$locale
            ]);
            Route::current()->forgetParameter('locale');
            dd($locale);


        return $next($request);
    }
}
