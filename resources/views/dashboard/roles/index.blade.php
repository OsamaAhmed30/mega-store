@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">Roles</a></li>

 @section('title', "Roles") 

@endsection

@section('content')

<div class="d-flex justify-content-between">
    <a href="{{route('dashboard.roles.create')}}" class=" mb-3 mx-3 btn btn-primary" ><li class="fas fa-plus-circle mr-1"></li>Add Role</a>
   
</div>

<x-alert type='success'/>
<x-alert type='danger'/>

<table class="table">
    <thead>
       
        <th>Id</th>
        <th>Name</th>
        <th>Created At</th>
        <th colspan="2"></th>
        <tbody>
           
            @forelse ($roles as $role)
                <tr>
                  
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                   
                    <td>{{$role->created_at}}</td>
                    <td> 
                        <a class="btn btn-sm btn-outline-success " href="{{route('dashboard.roles.edit',$role->id)}}"><li class="mr-1 fas fa-edit"></li>Edit</a>
                       
                       
                        <a href="{{route('dashboard.roles.show',$role->id)}}" class="btn btn-sm btn-outline-secondary"><li class="mr-1 fas fa-list"></li>Details</a>
                       
                        <form class="d-inline-block" action="{{route(isset($trash) ?'dashboard.roles.force-delete':'dashboard.roles.destroy',$role->id)}}" method="post">
                            @csrf
                            {{-- Form Method Spoofing --}}
                            @method('delete')
    
                            <button class="btn btn-sm btn-outline-danger"><li class="mr-1 fas fa-trash"></li>Delete</button>
                        </form>
                       
                    </td>
                </tr>
            @empty
            <td colspan="7" class="text-center">No Roles Found</td>
            @endforelse

        </tbody>
    </thead>
</table>

    {{$roles->withQueryString()->links()}}


@endsection