<div class="col-md-4">
    <div class="product-item" style="text-align:left;">
        <div class="labels">
            @if($product->isNew())
                <span class="badge badge-warning">Новинка</span>
            @endif
            @if($product->isRecommend())
                <span class="badge badge-success">Рекомендуемое</span>
            @endif
            @if($product->isHit())
                <span class="badge badge-danger">Хит</span>
            @endif
        </div>
        <a href="#"><img src="{{Storage::url($product->image)}}" alt="{{$product->__('name')}}" style="width: 250px; height: 250px"></a>
        <div class="down-content">
            <a href="#"><h4>{{$product->__('name')}}</h4></a>
            <h6> {{$product->price}} {{App\Repositories\CurrencyConversion::getCurrencySymbol()}}</h6>
            <p>{{Str::limit($product->__('description'), 50)}}</p>

            <form action="{{route('basket-add', $product->id)}}" method="POST" id="addProduct">
                @if($product->isAvailable())
                    <button type="submit" class="filled-button" role="button">В корзину</button>
                @else
                    <button style="background-color:#000;" type="submit" class="filled-button" role="button" disabled>Нет в наличии</button>
                @endif

                <a href="{{route('product', [isset($category) ? $category->code : $product->category->code, $product->code])}}"
                   class="filled-button2" role="button">
                    Подробнее</a>
                @csrf
            </form>
            <br>
            <br>
            <ul class="stars">
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
            </ul>
            <span>Reviews (16)</span>
        </div>
    </div>
</div>
