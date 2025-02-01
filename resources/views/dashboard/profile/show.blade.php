
@extends('layouts.dashboard')
@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a class="breadcrumb-item active">Profile</a></li>
 @section('title', "$profile->name Profile")  
@endsection
@section('content')
<x-alert type='success'/>
<x-alert type='danger'/>
<div class="card" style="width: 18rem;">
    <img src={{asset("dist/img/avatar5.png")}} class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">{{"$profile->first_name $profile->last_name"}}</h5>
      <p class="card-text">{{"$profile->birth_date"}}</p>
      <a href="{{route('dashboard.profile.edit')}}" class="btn btn-primary">Edit Profile</a>
    </div>
  </div>

  @endsection