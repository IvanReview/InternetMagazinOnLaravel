<p> Неуважаемый товарищ {{$name}}!! </p>
<p> @lang('mail.order_created.your_order') {{ $fullSum }} создан </p>
<table>
    <tbody>
         @foreach($order->products as $product)
             <td><span class="badge">{{$product->countInOrder}}</span>
             <td>{{$product->__('name')}}</td>
             <td>{{$product->price}} ₽</td>
             <td>Общая стоимость: {{$product->getPriceForCount()}}</td>
         @endforeach
    </tbody>
</table>
