@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">Edit Product</a></li>
 @section('title', "Edit Product")  
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.products.update',$product->id)}}" enctype="multipart/form-data" method="post">
        @csrf
        @method('put')
      @include('dashboard.products._Form',['button_label'  => 'Update'])

    </form>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
<script>


var input = document.querySelector('input[name=tags]');

// initialize Tagify on the above input node reference
new Tagify(input)
</script>
@endpush