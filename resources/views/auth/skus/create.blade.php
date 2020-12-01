@extends('auth.layout.master')

@section('title', 'Создать свойство')

@section('content')
    <div class="col-md-12">
            <h1>Добавить Sku</h1>
        <br>

        <form method="POST" enctype="multipart/form-data" action="{{ route('skus.store', $product) }}">
            <div>
                @csrf
                <br>
                <div class="form-group  row">
                    <label for="price" class="col-sm-2 col-form-label">Цена: </label>
                    <div class="col-sm-2">
                        @include('auth.layout.error', ['fieldName' => 'price'])
                        <input type="text" class="form-control" name="price" id="price" value="">
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <label for="count" class="col-sm-2 col-form-label">Кол-во: </label>
                    <div class="col-sm-2">
                        @include('auth.layout.error', ['fieldName' => 'count'])
                        <input type="text" class="form-control" name="count" id="count" value="">
                    </div>
                </div>
                <br>

               @foreach($product->properties as $property)
                    <div class="form-group  row">
                        <label for="category_id" class="col-sm-2 col-form-label">{{$property->name}}: </label>
                        <div class="col-sm-6">
                            @include('auth.layout.error', ['fieldName' => 'property_id[]'])
                            <select name="property_id[{{$property->id}}]" class="form-control">
                                @foreach($property->propertyOptions as $option)
                                    <option value="{{ $option->id }}">
                                        {{ $option->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                @endforeach

                {{--<div class="form-group">
                    <div>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="name" >Название en: </label>
                        <input type="text" class="form-control" name="name_en" id="name_en" value="">
                    </div>
                </div>
                <br>--}}


                <button class="btn btn-primary">Сохранить</button>
                <br>
            </div>
        </form>

    </div>
@endsection


