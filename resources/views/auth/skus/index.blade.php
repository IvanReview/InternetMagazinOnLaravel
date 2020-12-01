@extends('auth.layout.master')

@section('title', 'Свойства')

@section('content')
    <div class="col-md-12">
        <h1>Товарные предложения</h1>
        <h2>{{$product->name}}</h2>
        <table class="table">
            <tbody>
            <tr>
                <th>#</th>
                <th>Товарные предложения</th>
                <th>Действия</th>
            </tr>
            @foreach($skus as $sku)
                <tr>
                    <td>{{ $sku->id }}</td>
                    <td>{{ $sku->propertyOptions->map->name->implode(', ') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form  onsubmit="if(confirm('Delete?')){return true} else {return false}"
                                action="{{ route('skus.destroy', [$product,$sku]) }}" method="POST"
                            >
                                <a class="btn btn-success" type="button" href="{{ route('skus.show', [$product,$sku]) }}">
                                    Открыть
                                </a>
                                <a class="btn btn-warning" type="button" href="{{ route('skus.edit', [$product,$sku]) }}">
                                    Редактировать
                                </a>
                                <a class="btn btn-info" type="button"
                                   href="{{ route('property-options.index', [$product,$sku]) }}"
                                >
                                    Добавить значение
                                </a>
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger" type="submit" value="Удалить">
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a class="btn btn-primary" type="button" href="{{ route('skus.create', $product) }}">
            Добавить товарные предложения
        </a>
        {{$skus->links()}}
    </div>
@endsection
