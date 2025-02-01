<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user-id',
        'first_name',
        'last_name',
        'street_address',
        'birth_date',
        'city',
        'state',
        'country',
        'locale',
        'postal_code',
        'gender'
    ];

    protected $primaryKey = 'user_id';

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->withDefault();
    }
}
