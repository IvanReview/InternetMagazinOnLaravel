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
        $orderId = session('orderId');

        //Если корзина пустая
        if (is_null($orderId) && $createOrder) {
            //проверяем авторезирован ли пользователь и добавляем id в таблицу
            $data = [];
            if (Auth::check()) {
                $data['user_id'] = Auth::id();
            }
            //если сессия пустая добавляем запись в табл заказы(order) и запись в сессию
            $this->order = Order::create($data);
            session(['orderId' => $this->order->id]);
        } else {

            //если в корзине есть продукты или что-то добавлялось в корзину, выбирам объект модели(order) по id
            $this->order =  Order::find($orderId);
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
        if ($this->order->products->contains($product->id)) {
            //получаем доступ к промежуточной таблице и увеличиваем столбец count
            $pivotRow = $this->order->products()->where('product_id', $product->id)->first()->pivot;
            $pivotRow->count++;
            //Если чило запрашиваемого товара больше чем есть
            if ($pivotRow->count > $product->count){
                return false;
            }
            $pivotRow->update();

        } else {
            if ($product->count == 0){
                return false;
            }
            //добавление нового товара в корзину
            $this->order->products()->attach($product->id);//вставка записи в промежуточную таблицу (order_id есть, product_id передаем в attach)
        }

        Order::changeFullSum($product->price);
        return true;
    }


    /**
     * @param Product $product
     */
    public function deleteProduct(Product $product)
    {
        if($this->order->products->contains($product->id)){
            //получаем доступ к промежуточной таблице
            $pivotRow = $this->order->products()->where('product_id', $product->id)->first()->pivot;
            if ($pivotRow->count < 2){
                $this->order->products()->detach($product->id);//находим нужный объект модели и открепляем запись в промежуточной табл order_product по $productId
            }
            else{
                $pivotRow->count--;
                $pivotRow->update();
            }

        }

        Order::changeFullSum(-$product->price);
    }

    //проверка доступности количества товара
    public function countAvailable($updateCount = false)
    {
        foreach ($this->order->products as $productInOrder){
            //количество товара в заказе
            $count = $this->order->products()->where('product_id', $productInOrder->id)->first()->pivot->count;
            //если число товаров в заказе больше чем есть товаров на складе
            if ($count > $productInOrder->count){
                return false;
            }
            if ($updateCount){
                $productInOrder->count = $productInOrder->count - $count;
                $productInOrder->save();
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

        //Отправка почты в OrderCreated формируется вид сообщения
        Mail::to($email)->send(new OrderCreated($name, $this->getOrder()));

        return $this->order->saveOrder($name, $phone, $email);
    }



}

