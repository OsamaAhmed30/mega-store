@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">Add Category</a></li>
 @section('title', "Add Category")  
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.categories.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.categories._Form')
    </form>
</div>
@endsection