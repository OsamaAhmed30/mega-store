<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'store_id',
        'payment_method',
        'status',
        'payment_status',
        'shipping',
        'tax',
        'discount',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }
    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }
    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')->where('type', '=', 'shipping');
    }
    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')->where('type', '=', 'billing');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->as('order_item') //we cahnge name pivot to order_item (see deductProductListener)
            ->withPivot([
                'product_name', 'price', 'quantity', 'options'
            ]);
    }
    protected static function booted()
    {
        //static::observe(OrderObserver::class);
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }
    public static function getNextOrderNumber()
    {

        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');

        if ($number) {
            return $number + 1;
        }

        return $year . '0001';
    }
}
