<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\IRepositories\Cart\ICartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected ICartRepository $cart;

     function __construct(ICartRepository $cart)
     {
        $this->cart = $cart;
     }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $items = $this->cart->get();
        //return $items;
        return view('front.cart', ['cart'=>$this->cart]);
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'=>'required|int|exists:products,id',
            'quantity'=>['nullable','int','min:1']
        ]);
        $product = Product::findorfail($request->post('product_id'));
       
        $this->cart->add($product,$request->post('quantity'));
        return back()->with('success','Great! Product Added Successfully');

    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'quantity'=>['required','int','min:1']
        ]);
        $this->cart->update($id,$request->post('quantity'));
        
       // return response('Great! Product Added Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->cart->delete($id);
    }
}
