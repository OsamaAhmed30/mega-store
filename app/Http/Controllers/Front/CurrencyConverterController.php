<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'currency_code'=>'required|string|size:3',
        ]);
       $currencyCode = $request->input('currency_code');
       $baseCurrencyCode= config('app.currency');
        $cacheKey = "currency_rates_$currencyCode";
       $rate = Cache::get( $cacheKey,0);
        if (!$rate) {
             $converter = app('cureency.converter');
        $rate=$converter->convert($baseCurrencyCode , $currencyCode);
        Cache::put('currency_rates',$rate,now()->addMinutes(60));
        }

       Session::put('currency_code',$currencyCode);

        Session::put('currency_rate',$rate);
        return back();

    }
    
}
