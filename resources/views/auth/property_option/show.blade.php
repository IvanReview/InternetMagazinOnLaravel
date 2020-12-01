@extends('auth.layout.master')

@section('title', 'Свойство ' . $propertyOption->name)

@section('content')
    <div class="col-md-12">
        <h1 style="color: green">Вариант свойства: {{$propertyOption->name}}</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>Поле</th>
                <th>Значение</th>
            </tr>
            <tr>
                <td>ID</td>
                <td>{{ $propertyOption->id }}</td>
            </tr>
            <tr>
                <td>Свойство</td>
                <td>{{ $property->name }}</td>
            </tr>

            <tr>
                <td>Название</td>
                <td>{{ $propertyOption->name }}</td>
            </tr>
            <tr>
                <td>Название en</td>
                <td>{{ $propertyOption->name_en }}</td>
            </tr>


            {{--<tr>
                <td>Кол-во товаров</td>
                <td>{{ $category->products->count() }}</td>
            </tr>--}}
            </tbody>
        </table>
    </div>
@endsection

