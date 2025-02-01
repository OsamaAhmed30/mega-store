<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory ,Notifiable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo_image',
        'cover_image',
        'status',
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    //two timestamps columns used it if changed these name;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $connection = 'mysql'; // we need this if use not default connection

    protected $keyType = 'int'; // use it if pk if not 'int'

    protected $table= 'stores'; // we need this if table name is not plural of model name
    protected $primaryKey = 'id'; // use it if pk not 'id'
    public $incrementing = true; // use it if pk not auto increment ... true = auto increment  false = not auto increment 

    public $timestamps = true;  // use it if we dont use timesstamps .. true = we use timestamps false = not use timesstamps 

}
