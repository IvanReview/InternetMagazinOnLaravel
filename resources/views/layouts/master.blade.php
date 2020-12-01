<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@lang('main.online_shop')  @yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script
        src="https://code.jquery.com/jquery-3.5.1.slim.js"
        integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM="
        crossorigin="anonymous"></script>
    <script src="/js/bootstrap.min.js"></script>
    {{--<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
   {{-- <link href="/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="/css/starter-template.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/assets/css/templatemo-sixteen.css">
    {{--<link rel="stylesheet" href="/assets/css/owl.css">--}}
</head>
<body>

<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/"><h2>{{--Sixteen <em>Technics</em>--}} @lang('main.online_shop')</h2></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li {{--@routeactive('index')--}} class="nav-item" >
                        <a class="nav-link" href="{{route('index')}}">{{__('main.all_products')}}
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li {{--@routeactive('categories')--}} class="nav-item">
                        <a class="nav-link" href="{{route('categories')}}">@lang('main.categories')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('locale',__('main.set_lang'))}}"> @lang('main.set_lang')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('basket')}}"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                            @lang('main.cart')<span class="cart"></span>
                        </a>
                    </li>
                    <li class="dropdown nav-item">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$currencySymbol}}
                        </a>
                        <div class="dropdown-menu">
                            @foreach($currencies as $currency)
                                <a class="dropdown-item" href="{{route('currency', $currency->code)}}">{{$currency->symbol}}</a>
                            @endforeach
                        </div>
                    </li>

                    @auth {{--проверяет залогирован ли пользователь--}}
                    <ul class="nav navbar-nav navbar-right">
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{route('home')}}">Панель администратора</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="{{route('person.order.index')}}">Мои заказы</a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route('get-logout')}}">Выход</a>
                        </li>
                    </ul>
                    @endauth

                    @guest {{--отображает информацию для не зарегестрированных--}}
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="nav-link" href="{{route('login')}}">Войти</a></li>
                    </ul>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container">
    <div class="starter-template">
        @if(session()->has('success'))
            <p class="alert alert-success">{{session()->get('success')}} </p>
        @endif
        @if(session()->has('warning'))
            <p class="alert alert-warning">{{session()->get('warning')}} </p>
        @endif
        <p class="alert alert-primary productAdd" style="display: none">Товар Добавлен</p>
        <p class="alert alert-warning productDel" style="display: none">Товар Удален</p>

        @yield('content')
    </div>
</div>


<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6"><p>Категория товаров</p>
                <ul>
                    @foreach($categories as $category)
                        <li><a href="{{route('category', $category->code)}}">{{$category->__('name')}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6"><p>Самые популярные товары</p>
               <ul>
                   @foreach($bestProducts as $product)
                       <li>
                           <a href="{{route('product', [$product->category->code, $product->code])}}">
                               {{$product->name}}
                           </a>
                       </li>
                   @endforeach
               </ul>
            </div>
        </div>
    </div>
</footer>

{{--<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>--}}
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

{{--<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/owl.js')}}"></script>
<script src="{{asset('assets/js/slick.js')}}"></script>
<script src="{{asset('assets/js/isotope.js')}}"></script>
<script src="{{asset('assets/js/accordions.js')}}"></script>--}}

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('js/myscript.js') }}" defer></script>
</body>
</html>

