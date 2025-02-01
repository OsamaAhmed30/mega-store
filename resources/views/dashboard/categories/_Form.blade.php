
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
    <x-form.label >Category Name</x-form.label>
    <x-form.input name='name' type='text' :value="$category->name" placeholder='Category Name' class="form-control"/>
  </div>
<div class="form-group">
    <x-form.label>Parent Category</x-form.label>
   <x-form.select name='parent_id' :options="$parents" :value="$category->parent_id"/>
  </div>
  <div class="form-group">
    <x-form.label>Description</x-form.label>
    <x-form.textarea  class="form-control" name="description" rows="3" placeholder="Describe  Category" :value="$category->description"/>
  </div>
  <div class="form-group">
    <x-form.label for="exampleInputFile">File input</x-form.label>
    <div class="input-group">
      <div class="custom-file">
        <x-form.input name='image' type='file' class='custom-file-input' id='exampleInputFile' accept='image/jpg , image/jpeg , image/png' />
        <x-form.label class="custom-file-label" for="exampleInputFile">{{old('image', $category->image)??'Choose file'}}</x-form.label>
       
      </div>
      
    </div>
  </div>
  <div class="form-group">
   
   
      
        <x-form.radio name='status' :options="['active'=>'Active','archived'=>'Archived']" :state="$category->status" />
       

      
     
      @error('status') <span class="text-danger">{{$message}}</span>
      @enderror
      
    
   
    
  </div>

  <button class="btn btn-primary" type="submit">{{$button_label ?? 'Add'}}</button>