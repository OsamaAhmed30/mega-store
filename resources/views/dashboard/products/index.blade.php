@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">{{isset($trash)?'Trashed Categories':'Categories'}}</a></li>
@if (isset($trash))
 @section('title', "Trashed Ctaegories")  
 @else
 @section('title', "Products") 
 @endif
@endsection

@section('content')

<div class="d-flex justify-content-between">
   
    @if (isset($trash))
    <a href="{{route('dashboard.categories.index')}}" class=" mb-3 mx-3 btn btn-success" ><li class="fas fa-list mr-1"></li>{{'Categories'}}</a>  
    
    @else
    <a href="{{route('dashboard.products.create')}}" class=" mb-3 mx-3 btn btn-primary" ><li class="fas fa-plus-circle mr-1"></li>Add Category</a>
    <a href="{{route('dashboard.categories.trash')}}" class=" mb-3 mx-3 btn btn-danger" ><li class="fas fa-trash mr-1"></li>{{ 'Recyclbin'}}</a>          
    @endif
   
</div>

<x-alert type='success'/>
<x-alert type='danger'/>
<form method="GET" action="{{URL::current()}}" class="d-flex justify-content-between w-100 p-1 ">
    <x-form.input name='name' type='text' class="form-control mx-2" placeholder='Name' :value="request('name')"/>
    <select name="status" class="form-control " >
        <option value="">All</option>
        <option value="active" @selected( request('status') == 'active' ?? '')>Active</option>
        <option value="archived"  @selected( request('status') == 'archived' ?? '')>Archived</option>
    </select>
    <button type="submit" class="btn btn-dark mx-1">Filter</button>
</form>


<table class="table">
    <thead>
        <th>Image</th>
        <th>Name</th>
        <th>Category</th>
        <th>Store</th>
        <th>price</th>
        <th>Original price</th>
        <th>Rating</th>
        <th>featured</th>
        <th>Status</th>
        <th colspan="2"></th>
        <tbody>
           
            @forelse ($products as $product)
                <tr>
                    <td>
                        @if ($product->image)
                        <img class="img-table" src={{ $product->image_url }} alt={{$product->name}}>
                        @endif
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->category->name ?? $product->category_id  }}</td>
                    <td>{{$product->store->name ?? $product->store_id  }}</td>
                    <td>{{$product->price }}</td>
                    <td>{{$product->compare_price  }}</td>
                    <td>{{$product->rating  }}</td>
                    <td>{{$product->featured  }}</td>
                    <td>{{$product->status}}</td>
                    <td>
                        @if (isset($trash))
                        <form class="d-inline-block" action="{{route('dashboard.products.restore',$product->id)}}" method="post">
                            @csrf
    
                            {{-- Form Method Spoofing --}}
                            @method('put')
    
                            <button class="btn btn-sm btn-outline-primary"><li class="mr-1 fas fa-reply"></li>Restore</button>
                        </form>
                        
                        @else
                        <a class="btn btn-sm btn-outline-success " href="{{route('dashboard.products.edit',$product->id)}}"><li class="mr-1 fas fa-edit"></li>Edit</a>
                        @endif
                       
                        
                        <form class="d-inline-block" action="{{route(isset($trash) ?'dashboard.products.force-delete':'dashboard.products.destroy',$product->id)}}" method="post">
                            @csrf
    
                            {{-- Form Method Spoofing --}}
                            @method('delete')
    
                            <button class="btn btn-sm btn-outline-danger"><li class="mr-1 fas fa-trash"></li>Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
            <td colspan="7" class="text-center">No products Found</td>
            @endforelse

        </tbody>
    </thead>
</table>

    {{$products->withQueryString()->links()}}


@endsection