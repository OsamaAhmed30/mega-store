@props(['type'=>'radio','options' ,'name','state'=>''])

@foreach($options as $key => $value)
<div class="form-check">
<input type="{{$type}}" name="{{$name}}" value="{{$key}}" {{$attributes->class(["form-check-input"])}}  @checked(old($name ,$key) == $state)>
<label>{{$value}}</label>
</div>
@endforeach