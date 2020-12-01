@extends('auth.layout.master')

@section('title', 'Создать свойство')

@section('content')
    <div class="col-md-12">
            <h1>Добавить Свойство</h1>
        <br>

        <form method="POST" enctype="multipart/form-data" action="{{ route('properties.store') }}">
            <div>
                @csrf
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


