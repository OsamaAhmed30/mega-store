<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\IRepositories\Cart\ICartRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartRepository implements ICartRepository
{
    protected  $items;
    
    function __construct()
    {
       $this->items = collect([]);
    }

    public function get():Collection{
        if (!$this->items->count()) {
            $this->items = Cart::with('product')->get();
        }
       
       return $this->items;
       
       
    }
    public function add(Product $product,$quantity=1){

        $item =  Cart::where('product_id','=',$product->id)
        ->first();
        if (!$item) {
        
         $cart = Cart::create([
            'user_id'=>Auth::id(),
            'product_id'=>$product->id,
            'quantity'=>$quantity,
        ]);
        $this->get()->push($cart);
        return $cart;
    }

    return $item->increment('quantity' ,$quantity);
    }
    public function update($id, $quantity){
        Cart::where('id','=',$id)->update(['quantity'=>$quantity]);
        
    }
    public function delete($id){
        Cart::where('product_id','=',$id)
        ->delete();
    }
    public function empty(){
        Cart::query()->delete();
    }
    public function totalBeforeDiscount():float{

        return (float) $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->compare_price;
        });
    }
    public function total():float{
        return (float) $this->get()->sum(function ($item) {
            
            return $item->quantity * $item->product->price;
        });
    }
    public function totalDiscount():float{

        return (float)$this->get()->sum(function ($item) {
            return ($item->quantity * $item->product->compare_price)-( $item->quantity * $item->product->price);
        });

    }
   

  

}