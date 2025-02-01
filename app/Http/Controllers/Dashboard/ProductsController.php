<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Product::class , 'product');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('view-any',Product::class);

        $products = Product::with(['category', 'store'])->paginate(); //Eager Loading

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create',Product::class);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->authorize('create',Product::class);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // $this->authorize('update',$product);
        if ($product->status != 'active') {
            return view('not-found');
        }

        return view('dashboard.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // $this->authorize('update',$product);
        $categories = Category::all();
        $stores = Store::all();
        $tags = implode(',', $product->tags()->pluck('name')->toArray());

        return view('dashboard.products.edit', compact('product', 'categories', 'stores', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // $this->authorize('update', $product);

        $product->update($request->except('tags'));
        $allRequestTags = []; //empty tags array comes from request
        $tags = json_decode($request->post('tags')); //extract tags comes from request and convert it to json becuase we using tagify library
        foreach ($tags as $item) {  // loop in tags and separate each item from it and push it to allRequestTags array
            $item_tag = explode('[', $item->value);
            foreach ($item_tag as $tag)
                if ($tag) {
                    $allRequestTags[] = $tag;
                }
        }

        $saved_tags = Tag::all();
        $tag_ids = [];
        foreach ($allRequestTags as $tag_name) {

            $slug = Str::slug($tag_name);
            $tag = $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'slug' => $slug,
                    'name' => $tag_name
                ]);
            }
            $tag_ids[] = $tag->id;
            $product->tags()->sync($tag_ids);
        }

        return redirect()->route('dashboard.products.index')->with('success', 'Nice Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product  $product)
    {
        // $this->authorize('delete', $product);

    }
}
