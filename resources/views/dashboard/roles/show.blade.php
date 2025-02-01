@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="{{route('dashboard.categories.index')}}" class="breadcrumb-item active">Categories</a></li>
<li class="breadcrumb-item"><a class="breadcrumb-item active">{{$category->name}}</a></li>

 @section('title', $category->name) 
 
@endsection

@section('content')

<div class="d-flex justify-content-between">
   
    <a href="{{route('dashboard.categories.index')}}" class=" mb-3 mx-3 btn btn-success" ><li class="fas fa-list mr-1"></li>Categories</a>  
    
    
</div>

<x-alert type='success'/>
<x-alert type='danger'/>



<table class="table">
    <thead>
        <th>Product Name</th>
        <th>Store</th>
        <th>Price</th>
        <th>Status</th>
        <th>:Created At</th>
        <tbody>
           @forelse($products as $product)
          
                <tr>
                    <td>{{$product->name }}</td>
                    <td>{{$product->store->name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->status}}</td>
                    <td>{{$product->created_at}}</td>
                
                </tr>
           @empty 
           <td colspan="5" class="text-center">No Products Found</td>

           @endforelse

        </tbody>
    </thead>
</table>
{{$products->links()}}
@endsection