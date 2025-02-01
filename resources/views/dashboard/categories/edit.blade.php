@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">Add Category</a></li>
 @section('title', "Add Category")  
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.categories.update',$category->id)}}" enctype="multipart/form-data" method="post">
        @csrf
        @method('put')
      @include('dashboard.categories._Form',['button_label'  => 'Update'])

    </form>
</div>
@endsection