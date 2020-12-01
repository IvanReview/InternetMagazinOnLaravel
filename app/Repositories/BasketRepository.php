<?php

namespace App\Repositories;

use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BasketRepository
{
    /**
     * Содержит Модель заказа
     *
     */
    protected $order;

    /**
     * BasketRepository constructor.
     * @param bool $createOrder
     */
    public function __construct($createOrder = false)
    {
        $order = session('order');

        //Если корзина пустая
        if (is_null($order) && $createOrder) {
            //проверяем авторезирован ли пользователь и добавляем id в таблицу
            $data = [];
            if (Auth::check()) {
                $data['user_id'] = Auth::id();
            }

            $data['currency_id'] = CurrencyConversion::getCurrentCurrencyFromSession()->id;

            $this->order = new Order($data);

            session(['order' => $this->order]);
        } else {
            $this->order = $order;
        }
    }

    /**
     * Получение заказа из сессии
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }


    /**
     * @param Product $product
     * @return bool
     */
    public function addProduct(Product $product)
    {
        //проверяем содержится ли данный продукт в корзине
        if ($this->order->products->contains($product)) {
            $pivotRow = $this->order->products->where('id',$product->id)->first();
            if ($pivotRow->countInOrder >= $product->count){
                return false;
            }
            $pivotRow->countInOrder++;

        } else {
            if ($product->count == 0){
                return false;
            }
            //добавление нового товара в корзину
            $product->countInOrder = 1;
            $this->order->products->push($product);
        }

        return true;
    }


    /**
     * @param Product $product
     */
    public function deleteProduct(Product $product)
    {
        if($this->order->products->contains($product)){
            $pivotRow = $this->order->products->where('id',$product->id)->first();

            if ($pivotRow->countInOrder < 2){
                $this->order->products->pop($product);
            }
            else{
                $pivotRow->countInOrder--;
            }
        }

    }

    //проверка доступности количества товара
    public function countAvailable($updateCount = false)
    {
        $products = collect([]);
        foreach ($this->order->products as $productInOrder){

            $product = Product::find($productInOrder->id);
            if ($productInOrder->countInOrder > $product->count){
                return false;
            }
            if ($updateCount){
                $product->count = $product->count - $productInOrder->countInOrder;
                $products->push($product);
            }

            if ($updateCount){
                $products->map->save();
            }
        }
        return true;
    }


    public function saveOrderBasket($name, $phone, $email)
    {
        //При сохранении заказа вычитаем кол-во заказанного товара
        if(!$this->countAvailable(true)){
            return false;
        }

        $this->order->saveOrder($name, $phone, $email);
        //Отправка почты в OrderCreated формируется вид сообщения
        Mail::to($email)->send(new OrderCreated($name, $this->getOrder()));

        return true;
    }



}

