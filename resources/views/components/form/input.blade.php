@props(['type'=>'text','name' ,'value'=>''])

<input type="{{$type ?? 'text'}}"
 name="{{$name}}"
  value="{{ old($name,$value)}}"
  {{$attributes->class([
  "is-invalid" =>$errors->has($name)
  ])}}>
    @error($name)
    <span class="invalid-feedback">{{$message}}</span>
    @enderror