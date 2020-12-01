<div class="col-md-4">
    <div class="product-item" style="text-align:left;">
        <div class="labels">
            @if($sku->product->isNew())
                <span class="badge badge-warning">Новинка</span>
            @endif
            @if($sku->product->isRecommend())
                <span class="badge badge-success">Рекомендуемое</span>
            @endif
            @if($sku->product->isHit())
                <span class="badge badge-danger">Хит</span>
            @endif
        </div>
        <a href="#"><img src="{{Storage::url($sku->product->image)}}" alt="{{$sku->product->__('name')}}" style="width: 250px; height: 250px"></a>
        <div class="down-content">
            <a href="#"><h4>{{$sku->product->__('name')}}</h4></a>
            <h6> {{$sku->price}} {{App\Repositories\CurrencyConversion::getCurrencySymbol()}}</h6>
            <p>{{Str::limit($sku->product->__('description'), 50)}}</p>

            <form action="{{route('basket-add', $sku->product->id)}}" method="POST" id="addProduct">
                @if($sku->product->isAvailable())
                    <button type="submit" class="filled-button" role="button">В корзину</button>
                @else
                    <button style="background-color:#000;" type="submit" class="filled-button" role="button" disabled>Нет в наличии</button>
                @endif

                <a href="{{route('product', [isset($category) ? $category->code : $sku->product->category->code, $sku->product->code])}}"
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
