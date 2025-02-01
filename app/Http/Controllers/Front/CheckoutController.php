<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Repositories\IRepositories\Cart\ICartRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
  protected $cart;
    public function __construct(ICartRepository $cart)
    {
      $this->cart=$cart;
    }

    public function create(){
      $cart = $this->cart;
        if ($cart->get()->count()==0) {
          return redirect()->route('home');
        }
        return view('front.checkout',[
            'cart'=>$cart,
            'countries'=>Countries::getNames()
        ]);
    }

    public function store(Request $request){
      //return $request;
      $cart = $this->cart;
        $request->validate([
          // 'addr.billing.first_name'=>['required','string','max:25'],
          // 'addr.billing.last_name'=>['required','string','max:25'],
          // 'addr.billing.email'=>['required','email'],
          // 'addr.billing.phone_number'=>['required','string'],
          // 'addr.billing.city'=>['required'],
          // 'addr.billing.country'=>['required'],
        ]);

        $items= $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();
      try {
        $i=1;
        foreach ($items as $store_id => $cart_items) {
          $i =$i +1;
        $order= Order::create([
            'store_id'=>$store_id,
            'user_id'=>Auth::id(),
            'payment_method'=>'cod',            
        ]);
        foreach($cart_items as $item){
            OrderItem::create([
                'order_id'=>$order->id,
                'product_id'=>$item->product_id,
                'product_name'=>$item->product->name,
                'price'=>$item->product->price,
                'quantity'=>$item->quantity
            ]);
        }
        $types = ['billing','shipping'];
        if ($request->sameAddress == 'on'){
          foreach($types as $type){
           
            $address = $request->post('addr')['billing'];
            $address['type'] = $type;
           
           $order->addresses()->create($address);
          }
          
        }
        else{
          foreach($request->post('addr') as $type=>$address){
         
            $address['type'] = $type;
           
           $order->addresses()->create($address);

      }
        }
      
         //event('order.created',$order,Auth::user());
         //event(new OrderCreated($order));
      }
      //$cart->empty();
        DB::commit();

        event(new OrderCreated($order));

      }
       catch (Throwable $th) {
        DB::rollBack();
        throw $th;
      }
      return redirect()->route('orders.payments.create',$order);

    }
}
