
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
    <x-form.label >product Name</x-form.label>
    <x-form.input name='name' type='text' :value="$product->name" placeholder='product Name' class="form-control"/>
</div>
<div class="form-group">
    <x-form.label> Category</x-form.label>
   <x-form.select name='category_id' :options="$categories" :value="$product->category_id"/>
</div>
<div class="form-group">
    <x-form.label> Category</x-form.label>
   <x-form.select name='store_id' :options="$stores" :value="$product->store_id"/>
</div>
  <div class="form-group">
    <x-form.label>Description</x-form.label>
    <x-form.textarea  class="form-control" name="description" rows="3" placeholder="Describe  product" :value="$product->description"/>
  </div>
  <div class="form-group">
    <x-form.label for="exampleInputFile">File input</x-form.label>
    <div class="input-group">
      <div class="custom-file">
        <x-form.input name='image' type='file' class='custom-file-input' id='exampleInputFile' accept='image/jpg , image/jpeg , image/png' />
        <x-form.label class="custom-file-label" for="exampleInputFile">{{old('image', $product->image)??'Choose file'}}</x-form.label>
       
      </div>
      
    </div>
  </div>
  <div class="form-group">
    <x-form.label >Product Price</x-form.label>
    <x-form.input name='price' type='number' :value="$product->price" placeholder='product Price' class="form-control"/>
</div>
  <div class="form-group">
    <x-form.label >Compare Price</x-form.label>
    <x-form.input name='compare_price' type='number' :value="$product->compare_price" placeholder='Original Price' class="form-control"/>
</div>
  <div class="form-group">
    <x-form.label >Tags</x-form.label>
    <x-form.input name='tags' type='text' :value="$tags" class="form-control"/>
</div>
  <div class="form-group">
   <x-form.radio name='status' :options="['active'=>'Active','archived'=>'Archived','draft'=>'Draft']" :state="$product->status" />
    @error('status') <span class="text-danger">{{$message}}</span>
    @enderror 
  </div>

  <button class="btn btn-primary" type="submit">{{$button_label ?? 'Add'}}</button>

@push('scripts')
  <script src="{{asset('dist/js/tagify/tagify.js')}}"></script>
  <script src="{{asset('dist/js/tagify/tagify.polyfills.min.js')}}"></script>
  <link href="{{asset('dist/tagify/tagify.css')}}" rel="stylesheet" type="text/css" />
<script>
  

var input = document.querySelector('input[name=tags]');

// initialize Tagify on the above input node reference
new Tagify(input)
</script>
@endpush