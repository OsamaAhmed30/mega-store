<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Countries;

class OrderAddress extends Model
{
    use HasFactory;
    public $timestamps=false;

    protected $fillable=[
        'order_id',
        'type',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'street_address',
        'city',
        'postal_code',
        'state',
        'country',
    ];


    protected function Name(): Attribute
    {
       
        return Attribute::make(
            get: fn () =>"$this->first_name $this->last_name"  ,
           
        );
    }
    protected function CountryName(): Attribute
    {
       
        return Attribute::make(
            get: fn () =>Countries::getName($this->country)
           
        );
    }

}
