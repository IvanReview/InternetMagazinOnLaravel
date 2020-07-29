@extends('layouts.master')
@section('title', 'Корзина')
@section('content')

            <h1 style="margin-top: 80px ">Корзина</h1>
            <p>Оформление заказа</p>
            <div class="panel">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>Общая стоимость</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($order))
                    @foreach($order->products()->with('category')->get() as $product)
                    <tr>
                        <td>
                            <a href="{{route('product',[$product->category->code,$product->id])}}">
                                <img height="56px" src="{{Storage::url($product->image)}}">
                                {{$product->name}}
                            </a>
                        </td>
                        <td><span class="badge badge-secondary" id="basketCount">{{$product->pivot->count}}</span>
                            <div class="btn-group form-inline">
                                <form action="{{route('basket-remove', $product->id)}}" method="POST" id="delProduct">
                                    <button type="submit" class="btn btn-danger"><span><i class="fa fa-minus" aria-hidden="true"></i>
                                        </span></button>
                                    @csrf
                                </form>
                                <form action="{{route('basket-add', $product->id)}}" method="POST" id="addProduct">
                                    <button type="submit" class="btn btn-info"><span><i class="fa fa-plus" aria-hidden="true">
                                            </i></span></button>
                                    @csrf
                                </form>
                            </div>
                        </td>
                        <td>{{$product->price}} ₽</td>
                       {{-- Общая стоимость--}}
                        <td>{{$product->getPriceForCount()}}</td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <td colspan="3">Общая стоимость:</td>
                        <td>{{$order->getFullSum()}} ₽</td>
                    </tr>
                    </tbody>
                </table>
                <br>
                <div class="btn-group pull-right" role="group">
                    <a type="button" class="filled-button" href="{{route('basket-place')}}">Оформить заказ</a>
                </div>
            </div>

@endsection

