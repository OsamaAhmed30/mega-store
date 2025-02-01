
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
    <x-form.label >Role Name</x-form.label>
    <x-form.input name='name' type='text' :value="$role->name" placeholder='Role Name' class="form-control"/>
</div>
   
    
<fieldset>
  <legend>Abilities</legend>
    @foreach($abilities as $key=>$ability)
    <div class="row">
    <div class="col-md-6">
      {{__($ability)}}
    </div>
    <div class="col-md-2">
      <div class="form-check">
        <input class="form-check-input" type="radio" value="allow" name="abilities[{{$key}}]"  @checked(($existAbilities[$key]??'')=='allow') >
        <label class="form-check-label" for="flexRadioDefault1" >
         Allow
        </label>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-check">
        <input class="form-check-input" type="radio" value="deny" name="abilities[{{$key}}]" @checked(($existAbilities[$key]??'')=='deny') >
        <label class="form-check-label" for="flexRadioDefault1">
         Deny
        </label>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-check">
        <input class="form-check-input" type="radio" value="inherit" name="abilities[{{$key}}]" @checked(($existAbilities[$key]??'')=='inherit') >
        <label class="form-check-label" for="flexRadioDefault1">
          Inherit
        </label>
      </div>
    </div>
  </div>
  
    @endforeach
</fieldset>
  <button class="btn btn-primary" type="submit">{{$button_label ?? 'Add'}}</button>