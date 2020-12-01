@extends('auth.layout.master')

@isset($property)
    @section('title', 'Редактировать свойство ' . $property->name)
@endisset

@section('content')
    @if(isset($property))
    <div class="col-md-12">
            <h3>Редактировать категорию: <b>{{ $property->name }}</b></h3>

        <form method="POST" enctype="multipart/form-data" action="{{ route('properties.update', $property) }}">

            <div>
                @isset($property)
                    @method('PUT')
                @endisset
                @csrf
                    <div class="form-group">
                        <div>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <label for="name" >Название: </label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $property->name }}">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <label for="name" >Название en: </label>
                            <input type="text" class="form-control" name="name_en" id="name" value="{{ $property->name_en }}">
                        </div>
                    </div>

                    <br>

                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
    @endif
@endsection

