@extends('auth.layout.master')

@section('title', 'Вариант свойства')

@section('content')
    <div class="col-md-12">
            <h1>Вариант свойства</h1>
        <br>

        <form method="POST" enctype="multipart/form-data" action="{{ route('property-options.store', $property) }}">
            <div>
                @csrf
                <br>
                <div>
                    <h2> Свойство: {{$property->name}}</h2>
                </div>
                <br>

                <div class="form-group">
                    <div>
                        @error('name')
                             <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="name" >Название: </label>
                        <input type="text" class="form-control" name="name" id="name" value="">
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="name" >Название en: </label>
                        <input type="text" class="form-control" name="name_en" id="name_en" value="">
                    </div>
                </div>
                <br>


                <button class="btn btn-primary">Сохранить</button>
                <br>
            </div>
        </form>

    </div>
@endsection


