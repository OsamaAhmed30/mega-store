    <!-- Start Single Product -->
    <div class="single-product">
        <div class="product-image">
            <img src="{{$product->image_url}}" alt="#">
            @if ($product->discount_percent)
            <span class="sale-tag">-{{$product->discount_percent}}%</span>
            @endif
           
            <div class="button">
                @if ($product->quantity)
                <form action="{{route('cart.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}"/>
                    <input type="hidden" name="quantity" value="{{1}}"/>
                    <button type="submit" class="btn"><i class="lni lni-cart"></i> Add to Cart</button>
                </form>
                @else
                <h5 class="bg-danger text-light text-center p-2">Out Of Stock</h5>
                @endif
            </div>
        </div>
        <div class="product-info">
            <span class="category">{{$product->category->name}}</span>
            <h4 class="title"> 
                <a href="{{route('front.product.show',$product->slug)}}">{{$product->name}}</a>
            </h4>
            <ul class="review">
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star"></i></li>
                <li><span>{{$product->rating}} Review(s)</span></li>
            </ul>
            <div class="price">
                <span>{{Currency::format($product->price)}}</span> 
                @if ($product->compare_price)
                <span  class="discount-price">{{Currency::format($product->compare_price)}}</span>
                @endif
               
            </div>
        </div>
    </div>
    <!-- End Single Product -->
