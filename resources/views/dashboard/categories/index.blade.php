@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">{{isset($trash)?'Trashed Categories':'Categories'}}</a></li>
@if (isset($trash))
 @section('title', "Trashed Ctaegories")  
 @else
 @section('title', "Categories") 
 @endif
@endsection

@section('content')

<div class="d-flex justify-content-between">
   
    @if (isset($trash))
    <a href="{{route('dashboard.categories.index')}}" class=" mb-3 mx-3 btn btn-success" ><li class="fas fa-list mr-1"></li>Categories</a>  
    
    @else
    @if(Auth::user()->can('categories.create'))
      <a href="{{route('dashboard.categories.create')}}" class=" mb-3 mx-3 btn btn-primary" ><li class="fas fa-plus-circle mr-1"></li>Add Category</a>
    <a href="{{route('dashboard.categories.trash')}}" class=" mb-3 mx-3 btn btn-danger" ><li class="fas fa-trash mr-1"></li>{{ 'Recyclbin'}}</a>          
    @endif
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
        <th>Id</th>
        <th>Name</th>
        <th>Parent</th>
        <th>Products Count</th>
        <th>Status</th>
        <th>{{isset($trash)?'Deleted At':'Created At'}}</th>
        <th colspan="2"></th>
        <tbody>
           
            @forelse ($categories as $category)
                <tr>
                    <td>
                        @if ($category->image)
                        <img class="img-table" src={{ $category->image_url }} alt={{$category->name}}>
                        @endif
                    </td>
                   
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->parent->name }}</td>
                    <td>{{$category->products_count}}</td>
                    <td>{{$category->status}}</td>
                    <td>{{isset($trash)?$category->deleted_at:$category->created_at}}</td>
                    <td>
                        @if (isset($trash))
                        <form class="d-inline-block" action="{{route('dashboard.categories.restore',$category->id)}}" method="post">
                            @csrf
    
                            {{-- Form Method Spoofing --}}
                            @method('put')
    
                            <button class="btn btn-sm btn-outline-primary"><li class="mr-1 fas fa-reply"></li>Restore</button>
                        </form>
                        
                        @else
                        @can('categories.update')
                        <a class="btn btn-sm btn-outline-success " href="{{route('dashboard.categories.edit',$category->id)}}"><li class="mr-1 fas fa-edit"></li>Edit</a>
                        @endcan
                       
                        @endif
                        @can('categories.view')
                        <a href="{{route('dashboard.categories.show',$category->id)}}" class="btn btn-sm btn-outline-secondary"><li class="mr-1 fas fa-list"></li>Details</a>
                        @endcan
                        @can('categories.delete')
                        <form class="d-inline-block" action="{{route(isset($trash) ?'dashboard.categories.force-delete':'dashboard.categories.destroy',$category->id)}}" method="post">
                            @csrf
                            {{-- Form Method Spoofing --}}
                            @method('delete')
    
                            <button class="btn btn-sm btn-outline-danger"><li class="mr-1 fas fa-trash"></li>Delete</button>
                        </form>
                        @endcan
                       
                    </td>
                </tr>
            @empty
            <td colspan="7" class="text-center">No Categories Found</td>
            @endforelse

        </tbody>
    </thead>
</table>

    {{$categories->withQueryString()->links()}}


@endsection