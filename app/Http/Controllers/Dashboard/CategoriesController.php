<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Policies\ModelPolicy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class CategoriesController extends Controller
{

    public function __construct()
    {
       // $this->authorizeResource(ModelPolicy::class , 'category');
    }



    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        //we used filter scope created in Category Model
        //  $categories = Category::leftJoin('categories as parents' , 'parents.id' , '=' , 'categories.parent_id')
        //  ->select([
        //     'categories.*',
        //     'parents.name as parent_name'
        //  ])
        //  ->filter($request->all())
        //  ->orderBy('categories.name')
        //  ->paginate(); //Return Collection Object (Act as Array)
        if (Gate::allows('categories.view')) {
            $categories = Category::with('parent')->withCount(['products'=>function($query){
                $query->whereStatus('active');
            }])->filter($request->all())
             ->orderBy('categories.name')
             ->paginate();
    
            return view("dashboard.categories.index",compact('categories'));
        }
      abort(403) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('categories.create')) {
           abort(403);
        }
        $parents = Category::all();
        $category = new Category();
        return view("dashboard.categories.create",compact('parents','category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Gate::authorize('categories.create');

        $request->validate(Category::rules(),[

           

        ]);  // we create rules function in Category model
       
        //Request Merge
        $request->merge([
            'slug' => Str::slug($request->name . $request->id )
        ]);

        $data = $request->except('image');

        $data['image']=$this->uploadImage($request);
        
        //Mass Assignment
        $category = Category::create($data);


        //PRG Post Redirect Get
        return redirect()->route('dashboard.categories.index')->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
       // Gate::authorize('categories.view');

        $products = $category->products()->with('store')->paginate(5);
        try {
            return view("dashboard.categories.show",compact('category','products'));
        } catch (Exception $e ) {
            return view("not-found");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        //Gate::authorize('categories.update');

        $parents = Category::where('id','<>', $id)
        ->where(function ($query) use ($id)
         {
            $query->whereNull('parent_id')
            ->orWhere('parent_id','<>',$id);
            
        })->get();
       
        try {
            $category=Category::findorfail($id);
            return view("dashboard.categories.edit",compact('category','parents'));
        } catch (Exception $e ) {
            return view("not-found");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request,  $id)
    { 
        
        $data = $request->validated();  

        $category=Category::findorfail($id);
       // return $category;
        $old_image = $category->image;
        $data = $request->except('image');

        $new_image =$this->uploadImage($request);
        if ($new_image) {
            $data ['image'] = $new_image;
        }
        
        
        $category->update($data);
        if ($old_image && isset($data['image']) && $data['image']) {
            Storage::disk('public')->delete($old_image);
        }
     
        return redirect()->route('dashboard.categories.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        Gate::authorize('categories.delete');
        $category  = Category::findorfail($id);
        $category->delete();
        // if (isset($category['image'])) {
        //     Storage::disk('public')->delete($category['image']);
        // }
       

        return redirect()->route('dashboard.categories.index')->with('danger', 'Deleted Succefully');
    }
    protected function uploadImage (Request $request){
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $extensions = ['jpeg','jpg','png'];
        if ( !in_array($file->getClientOriginalExtension(),$extensions)) { 
            return;
        }
        
        $path=$file->store('uploads',['disk'=>'public']); 
        return $path;
    }



    public function trash()
    {
        $trash = true;
        $categories = Category::onlyTrashed()
        ->orderBy('categories.name')
        ->paginate();
        return view('dashboard.categories.index',compact('categories','trash'));
    }
    public function restore(Request $request, $id)
    {
       $category = Category::onlyTrashed()->findOrFail($id);

       $category ->restore();
        

        return redirect()->route('dashboard.categories.trash')->with('success', 'Restored Succefully');
    }
    public function forceDelete( $id)
    {
       
        $category  = Category::onlyTrashed()->findorfail($id);
        $category->forceDelete();
         if (isset($category['image'])) {
             Storage::disk('public')->delete($category['image']);
         }
       

        return redirect()->route('dashboard.categories.trash')->with('danger', 'Deleted Succefully for Ever');
    }
}
