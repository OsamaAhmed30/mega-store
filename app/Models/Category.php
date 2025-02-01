<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory,SoftDeletes ;

    protected $fillable = [

        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug'


    ];
    public function parent()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => '-'
        ]); // withdefault prevent null if no relation present
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public  function scopeFilter(Builder $builder , $filter) {
        //Method 1
        // if ($filter['name']??false) {
        //     $builder->where('name','LIKE',"%{$filter['name']}%");
        // }
        // if ($filter['status']??false) {
        //  $builder->whereStatus($filter['status']); // ===where('status','=',$status)
        //  //here we use created scope
        // }

        //Method 2

        $builder->when($filter['name']??false,function($builder,$value){
            $builder->where('name','LIKE',"%{$value}%");
        });
        $builder->when($filter['status']??false,function($builder,$value){
            $builder->whereStatus($value);
        });

    }


    public static function rules ($id = 0){
        return [
            'name'=> ["required",
            "string",
            "min:3",
            "max:255",
            "filter:html,css",
            Rule::unique('categories','name')->ignore($id),
            //custom rule 
            function ($attribute , $value , $fails) {
                if (strtolower($value) == 'laravel') {
                    $fails("this $attribute is forbidden");
                }
            },
            new Filter('create1')
        ],
            'parent_id'=>[
                'nullable',
                'int',
                'exists:categories,id'
            ],
            'description'=>[
                'nullable'
            ],
            'image'=>[
                'image',
                'max:3000000',
                'mimeTypes:image/jpeg,image/jpg,image/png',
                'dimensions:min-width=10,min-height=100'
            ],
            'status'=>'required|in:active,archived'
        ];
    }

    protected function ImageUrl(): Attribute
    {
        if (!$this->image) {
            return Attribute::make(
                get: fn () => asset('assets/images/categories/no-product.png'),

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
    

}
