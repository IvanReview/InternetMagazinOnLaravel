@extends('layouts.master')
@section('content')

       <h1 style="margin-top: 80px">{{ $product->name }}</h1>
        <h2>{{$category->name}}</h2>
        <p>Цена: <b>{{$product->price}} $</b></p>
        <img src="{{Storage::url($product->image)}}" style="width: 350px">
        <br>
        <br>
        <p>{{$product->description}}</p>
        <p style="font-weight: bold;"> <b>Количество на складе:</b>  {{$product->count}}</p>
        <br>

        <form action="{{route('basket-add', $product->id)}}" method="POST">
            @if($product->isAvailable())
                <button type="submit" class="btn btn-primary" role="button">Добавить в корзину</button>
            @else
                <button type="submit" class="btn btn-primary" role="button" disabled>Нет в наличии</button>
                <br>
                <br>
                <span>Сообщить мне когда появится товар</span>
                <br>
                <form method="POST ">
                    @csrf
                    <input type="text" name="email">
                    <button type="submit" class="btn btn-info">Send</button>
                </form>
            @endif
            @csrf
        </form>

@endsection
