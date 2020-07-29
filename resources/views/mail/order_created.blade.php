<p> Неуважаемый товарищ {{$name}}!! </p>
<p> Ваш заказ на {{ $fullSum }} создан </p>
<table>
    <tbody>
         @foreach($order->products as $product)
             <td><span class="badge">{{$product->pivot->count}}</span>
             <td>{{$product->name}}</td>
             </td>
             <td>{{$product->price}} ₽</td>
              Общая стоимость
             <td>{{$product->getPriceForCount()}}</td>
         @endforeach
    </tbody>
</table>
