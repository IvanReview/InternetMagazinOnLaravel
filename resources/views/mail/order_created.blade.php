<p> Неуважаемый товарищ {{$name}}!! </p>
<p> @lang('mail.order_created.your_order') {{ $fullSum }} создан </p>
<table>
    <tbody>
         @foreach($order->products as $product)
             <td><span class="badge">{{$product->pivot->count}}</span>
             <td>{{$product->__('name')}}</td>
             <td>{{$product->price}} ₽</td>
              Общая стоимость
             <td>{{$product->getPriceForCount()}}</td>
         @endforeach
    </tbody>
</table>
