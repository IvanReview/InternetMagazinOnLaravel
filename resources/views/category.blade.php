@extends('layouts.master')
@section('title', 'Категория: '.$category->name)
@section('content')
        <h1 style="margin-top: 80px">{{$category->__('name')}}</h1>
        <h3>Количество товаров - {{$category->products->count()}}</h3>
        <p>
            {{$category->__('description')}}
        </p>
        <div class="row">
            @foreach($category->products as $product)
                @include('card', compact('product'))
            @endforeach
        </div>
@endsection
