<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class LanguagesController extends Controller
{
    public function store (Request $request){

        $request->validate([
            'locale' =>'required|size:2'
        ]);

         Config::set('app.locale',$request->locale);
        //return Config::get('app.locale');
        return redirect()->back();

    }
    
}
