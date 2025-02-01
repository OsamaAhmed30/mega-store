@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">Add Role</a></li>
 @section('title', "Add Role")  
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.roles.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.roles._Form')
    </form>
</div>
@endsection