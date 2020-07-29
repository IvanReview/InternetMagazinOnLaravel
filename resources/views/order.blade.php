@extends('layouts.master')
@section('title', 'Оформить заказ')

@section('content')
    <h1 class="orderForm">Подтвердите заказ:</h1>
    <h5>Общая стоимость: <b>{{$order->calculateFullSum()}} ₽.</b></h5>
    <p>Укажите свои имя и номер телефона, чтобы наш менеджер мог с вами связаться:</p>
    <br>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <form action="{{route('basket-confirm')}}" method="POST">
                    <div class="container" style="text-align:left;">
                        <div class="form-group col-md-10">
                            <label for="name" class="control-label col-lg-10">Имя: </label>
                            <input type="text" name="name" id="name" value="" class="form-control" required>
                        </div>


                        <div class="form-group col-md-10">
                            <label for="phone" class="control-label  col-lg-10">Номер телефона: </label>
                            <input type="text" name="phone" id="phone" value="" class="form-control" required>
                        </div>
                        <br>
                        @guest
                            <div class="form-group col-md-10">
                                <label for="name" class="control-label  col-lg-10">Email: </label>
                                <input type="text" name="email" id="email" value="" class="form-control">

                            </div>
                        @endguest
                        @csrf
                        <input style="margin-left: 20px" type="submit" class="btn btn-success" value="Подтвердите заказ">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
