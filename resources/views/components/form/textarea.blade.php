@props(['name' ,'value'=>''])

<textarea type="{{$type ?? 'text'}}"
 name="{{$name}}"
 
{{$attributes->class([
 "form-control" ,
  "is-invalid" =>$errors->has($name)
  ])}}>{{ old($name,$value)}}</textarea>
    @error($name)
    <span class="invalid-feedback">{{$message}}</span>
    @enderror