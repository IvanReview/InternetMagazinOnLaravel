@extends('layouts.master')
@section('content')

    <h1 style="margin-top: 80px">{{ $product->__('name') }}</h1>
    <h2>{{$category->name}}</h2>
    <p>Цена: <b>{{$product->price}} $</b></p>
    <img src="{{Storage::url($product->image)}}" style="width: 350px">
    <br>
    <br>
    <p>{{$product->__('description')}}</p>
    <p style="font-weight: bold;"> <b>Количество на складе:</b>  {{$product->count}}</p>
    <br>

    @if($product->isAvailable())
        <form action="{{route('basket-add', $product->id)}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary" role="button">Добавить в корзину</button>
        </form>
    @else
        <span class="btn btn-primary" disabled>Нет в наличии</span>
        <br>
        <br>
        <span>Сообщить мне когда появится товар</span>
        <br>

            @if($errors->get('email'))
                <div class="alert alert-danger">
                    {!! $errors->get('email')[0] !!}
                </div>
            @endif

        <form method="POST" action="{{route('subscription', $product->id)}}">
            @csrf
            <input type="text" name="email">
            <button type="submit" class="btn btn-info">Send</button>
        </form>
    @endif

@endsection
