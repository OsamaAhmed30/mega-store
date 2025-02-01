@props([
    'name',
    'value'=>'',
    'options'=>[],
    'first_option'=>'Choose option'

])
<select name="{{$name}}" @class([
    "custom-select" ,"form-control" ,"is-invalid" =>$errors->has('option_id')])>
    <option value="">{{$first_option}}</option>
    @foreach ($options as $key=>$option)
    <option value="{{$key}}" @selected(old($name, $value) == $key ?? '')>{{$option->name?? $option}}</option>
    @endforeach
  </select>
  @error($name) 
  <span class="text-danger">{{$message}}</span>
  @enderror