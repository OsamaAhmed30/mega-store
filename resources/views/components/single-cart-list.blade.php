
@foreach ($items->get() as $item)

      <!-- Cart Single List list -->
  <div class="cart-single-list" id="{{$item->product_id}}">
    <div class="row align-items-center">
        <div class="col-lg-1 col-md-1 col-12">
            <a href="product-details.html"><img src="{{$item->product->image_url}}" alt="#"></a>
        </div>
        <div class="col-lg-4 col-md-3 col-12">
            <h5 class="product-name"><a href="{{route('front.product.show',$item->product->slug)}}">
                  {{$item->product->name}}</a></h5>
            <p class="product-des">
                <span><em>Department:</em> {{$item->product->category->name}}</span>
                <span><em>Color:</em> Black</span>
            </p>
        </div>
        <div class="col-lg-2 col-md-2 col-12">
            <div class="count-input">
                <input type="number" name="quantity" value="{{$item->quantity}}" class="form-control item-quantity" data-id="{{$item->id}}"/>
                   
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-12">
            <p>{{Currency::format($item->product->compare_price * $item->quantity)}}</p>
        </div>
        <div class="col-lg-2 col-md-2 col-12">
            <p>{{Currency::format(($item->product->compare_price * $item->quantity)-($item->product->price * $item->quantity))}}</p>
        </div>
        <div class="col-lg-1 col-md-2 col-12">
            <a class="remove-item" data-id="{{$item->product_id}}"><i class="lni lni-close"></i></a>
        </div>
    </div>
</div>
<!-- End Single List list -->
@endforeach
@push('scripts')
<script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>

<script >
    const csrf_token = "{{csrf_token()}}"
</script>
@vite(['resources/js/cart.js'])
@endpush