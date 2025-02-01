@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">Add Role</a></li>
 @section('title', "Update Role")  
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.roles.update',$role->id)}}" enctype="multipart/form-data" method="post">
        @csrf
        @method('put')
      @include('dashboard.roles._Form',['button_label'  => 'Update'])

    </form>
</div>
@endsection