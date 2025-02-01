<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Index() {
        $products =Product::with('category')->active()
        ->limit(8)
        ->latest()
        ->get();
  
        return view('front.home',compact('products'));
    }
    public function show(Product $product) {
       
        return view('front.product',compact('product'));
    }
}
