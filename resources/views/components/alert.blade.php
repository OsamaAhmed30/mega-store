@if (session()->has($type))
<div >
    
    <p class="alert alert-{{$type}}">
        {{session($type)}}
    </p>
  </div>
    
@endif

    
