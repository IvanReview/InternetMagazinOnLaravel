@extends('auth.layout.master')

@isset($property)
    @section('title', 'Редактировать вариант свойство ' . $propertyOption->name)
@endisset

@section('content')
    @if(isset($propertyOption))
    <div class="col-md-12">
            <h3>Редактировать вариант св-ва: <b>{{ $propertyOption->name }}</b></h3>

        <form method="POST" enctype="multipart/form-data"
              action="{{ route('property-options.update', [$property, $propertyOption]) }}"
        >
            <div>
                @isset($propertyOption)
                    @method('PUT')
                @endisset
                @csrf
                    <div class="form-group">
                        <div>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <label for="name" >Название: </label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $propertyOption->name }}">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <label for="name" >Название en: </label>
                            <input type="text" class="form-control" name="name_en" id="name" value="{{ $propertyOption->name_en }}">
                        </div>
                    </div>

                    <br>

                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
    @endif
@endsection

