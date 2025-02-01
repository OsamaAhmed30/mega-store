<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [

        'name',
        'store_id',
        'category_id',
        'slug',
        'description',
        'image',
        'price',
        'compare_price',
        'options',
        'rating',
        'featured',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, //Related Table (required)
            'product_tag', //Pivot Table  (optinal)
            'product_id', // foreign key of current Model(optinal)
            'tag_id',       //foreign key of related Model(optinal)
            'id',           //primary key of current Model(optinal)
            'id'            //primary key of related Model(optinal)
        );
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }
    public function scopeFilter(Builder $builder, $filters)
    {

        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['store_id'], function ($builder, $value) {
             $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function ($builder, $value) {
             $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {
            //method 1 
            //$builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ? )',[$value]);

            //method 2 the best performance
           // $builder->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id=product.id )',[$value]);

            //method 2 to by elquent
            $builder->whereExist( function($query) use ($value){
                $query->select(1)
                ->from('product_tag')
                ->whereRaw('product_id = product.id')
                ->where('tag_id',$value);
            });

             //method 3
            // return $builder->whereHas('tags', function ($builder) use ($value) {
            //      $builder->where('id', $value);
            // });
        });
        $builder->when($options['status'], function ($builder, $value) {
             $builder->where('status', $value);
        });
    }
    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    }
    protected function ImageUrl(): Attribute
    {
        if (!$this->image) {
            return Attribute::make(
                get: fn () => asset('assets/images/products/no-product.png'),

            );
        }
        if (Str::startsWith($this->image, ['https://', 'http://'])) {
            return Attribute::make(
                get: fn () => $this->image,

            );
        }
        return Attribute::make(
            get: fn () => asset('storage/' . $this->image),

        );
    }
    protected function DiscountPercent(): Attribute
    {
        if (!$this->compare_price) {
            return Attribute::make(
                get: fn () => 0,

            );
        }
        return Attribute::make(
            get: fn () => round(100 * (($this->compare_price - $this->price) / $this->compare_price), 2),

        );
    }
}
