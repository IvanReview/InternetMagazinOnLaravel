@extends('auth.layout.master')

@isset($property)
    @section('title', 'Редактировать Sku ' . $sku->name)
@endisset

@section('content')
    @if(isset($sku))
    <div class="col-md-12">
            <h3>Редактировать Sku: <b>{{ $product->name }}</b></h3>
        <form method="POST" enctype="multipart/form-data" action="{{ route('skus.update', [$product,$sku]) }}">
            <div>
                @isset($sku)
                    @method('PUT')
                @endisset
                @csrf
                    <div class="form-group row">
                        <label for="price" class="col-sm-2 col-form-label">Цена: </label>
                        <div class="col-sm-2">
                            @include('auth.layout.error', ['fieldName' => 'price'])
                            <input type="text" class="form-control" name="price" id="price"
                                   value="@isset($sku){{ $sku->price }}@endisset">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="count" class="col-sm-2 col-form-label">Кол-во: </label>
                        <div class="col-sm-2">
                            @include('auth.layout.error', ['fieldName' => 'count'])
                            <input type="text" class="form-control" name="count" id="count"
                                   value="@isset($sku){{ $sku->count }}@endisset">
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
                                        <option value="{{ $option->id }}"
                                        @if($sku->propertyOptions->contains($option->id))
                                            selected
                                        @endif
                                        >
                                            {{ $option->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                    @endforeach

                <button class="btn btn-primary">Редактировать</button>
            </div>
        </form>
    </div>
    @endif
@endsection

