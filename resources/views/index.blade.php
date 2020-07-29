@extends('layouts.master')
@section('title', 'Главная страница')
@section('content')
    <div class="starter-template">
        <div class="col-md-12">
            <div class="latest-products">
                <div class="section-heading">
                    <h2>Все продукты</h2>
                    <a href="#">Показать все продукты <i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
        <form method="GET" action="{{route('index')}}" class="form-inline" style="margin-bottom: 20px; display: flex">
            <div class="filters row">
                <div class="col-sm-6 col-md-3">
                    <input  type="text" name="price_from" id="price_from" class="form-control" size="6" placeholder="От" value="{{request()->price_from}}">
                    <input class="form-control"  type="text" name="price_to" id="price_to" size="6"  value="{{request()->price_to}}" placeholder="До" >
                    </label>
                </div>
                <div class="col-sm-2 col-md-2 form-check">
                    <label for="hit">
                        <input class="form-check-input" type="checkbox" name="hit" id="hit" @if(request()->has('hit')) checked @endif>
                    Хитяра </label>
                </div>
                <div class="col-sm-2 col-md-2 form-check">
                    <label for="new">
                        <input class="form-check-input" type="checkbox" name="new" id="new" @if(request()->has('new')) checked @endif >
                    Новинка </label>
                </div>
                <div class=" col-sm-2 col-md-2 form-check">
                    <label for="recommend">
                        <input class="form-check-input" type="checkbox" name="recommend" id="recommend" @if(request()->has('recommend')) checked @endif>
                        Рекомендуем</label>
                </div>
                <div class="col-sm-6 col-md-3">
                    <button type="submit" class="btn btn-primary">Фильтр</button>
                    <a href="{{route('index')}}" class="btn btn-warning">Сброс</a>
                </div>
            </div>
        </form>
        <div class="row">
            @foreach($products as $product)
                @include('card', compact('product'))
            @endforeach
        </div>

        {{ $products->appends([
            'price_from' => request()->price_from,
            'price_to'   => request()->price_to,
            'hit'        => request()->hit,
            'new'        => request()->new,
            'recommend'  => request()->recommend,
        ])->links() }}

    </div>

    <div class="best-features" style="text-align:left;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>About Sixteen Technics</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="left-content">
                        <h4>Looking for the best products?</h4>
                        <p><a rel="nofollow" href="https://templatemo.com/tm-546-sixteen-clothing" target="_parent">This template</a> is free to use for your business websites. However, you have no permission to redistribute the downloadable ZIP file on any template collection website. <a rel="nofollow" href="https://templatemo.com/contact">Contact us</a> for more info.</p>
                        <ul class="featured-list">
                            <li><a href="#">Lorem ipsum dolor sit amet</a></li>
                            <li><a href="#">Consectetur an adipisicing elit</a></li>
                            <li><a href="#">It aquecorporis nulla aspernatur</a></li>
                            <li><a href="#">Corporis, omnis doloremque</a></li>
                            <li><a href="#">Non cum id reprehenderit</a></li>
                        </ul>
                        <a href="about.html" class="filled-button">Read More</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-image">
                        <img src="assets/images/feature-image.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


