@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">Edit Profile</a></li>
 @section('title', "Edit Profile")  
@endsection
@section('content')

<div class="container">
    <form action="{{route('dashboard.profile.update')}}" enctype="multipart/form-data" method="post">
        @csrf
        @method('patch')
      
@if ($errors->any()) 
<div >
  <ul>
 @foreach ($errors->all() as $error) 
  <i class="list-group-item list-group-item-danger">{{$error}}</i>

  @endforeach
 </ul>
</div> 
@endif
<div class="form-group">
    <x-form.label >First Name</x-form.label>
    <x-form.input name='first_name' type='text'  placeholder='First Name' class="form-control" :value="$user->profile->first_name"/>
</div>
<div class="form-group">
    <x-form.label >Last Name</x-form.label>
    <x-form.input name='last_name' type='text'  placeholder='Last Name' class="form-control" :value="$user->profile->last_name"/>
</div>
<div class="form-group">
    <x-form.label >Birth Date</x-form.label>
    <x-form.input name='birth_date' type='date'  placeholder='Birth Date' class="form-control" :value="$user->profile->birth_date"/>
</div>
<div class="form-group">
   
    <x-form.radio :state="strtolower($user->profile->gender)" name="gender" :options="['male'=>'Male','female'=>'Female']" />
</div>
<div class="form-group">
  <x-form.label >Address</x-form.label>
  <x-form.input name='street_address' type='text'  placeholder='Address' class="form-control" :value="$user->profile->street_address"/>
</div>
<div class="form-group">
  <x-form.label >State</x-form.label>
  <x-form.input name='state' type='text'  placeholder='State' class="form-control" :value="$user->profile->state"/>
</div>
<div class="form-group">
  <x-form.label >City</x-form.label>
  <x-form.input name='city' type='text'  placeholder='City' class="form-control" :value="$user->profile->city"/>
</div>
<div class="form-row">
 
  <div class="col-md-4">
    <x-form.label >Postal Code</x-form.label>
    <x-form.input name='postal_code' type='text'  placeholder='Postal Code' class="form-control" :value="$user->profile->postal_code"/>
  </div>
  <div class="col-md-4">
    <x-form.label>Country</x-form.label>
    <select name="country" class="custom-select">
    <option value="">Choose Country</option>
    @foreach ($countries as $key=>$value)
    <option value="{{$key}}" @selected(old('country',$key)== $user->profile->country ??'')>{{$value}}</option>
    @endforeach
  </select>
  @error('country') 
  <span class="text-danger">{{$message}}</span>
  @enderror
  </div>
  <div class="col-md-4">
    <x-form.label>Locales</x-form.label>
    <select name="locale" class=
    "custom-select">
    <option value="">Choose Locale</option>
    @foreach ($locales as $key=>$value)
    <option value="{{$key}}"  @selected(old('locale',$key)== $user->profile->locale ??'')>{{$value}}</option>
    @endforeach
  </select>
  @error('locale') 
  <span class="text-danger">{{$message}}</span>
  @enderror

   
</div>


    </form>
    <button class="btn btn-primary mt-2" type="submit">{{$button_label ?? 'Add'}}</button>

</div>
@endsection