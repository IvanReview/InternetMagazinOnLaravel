<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\BasketRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{

    /**
     * Отображение корзины
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function basket()
    {
        //чтобы нельзя было зайти в пустую корзину см. middleware BasketNotEmpty
        $order = (new basketRepository())->getOrder();

        return view('basket', compact('order'));
    }


    /**
     * Вывод формы подтверждения заказа
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function basketOrderForm()
    {
        $basket = new basketRepository();
        $order = $basket->getOrder();

        if (!$basket->countAvailable()){
            session()->flash('warning', 'Товар увы '. 'кончился' );
            return redirect()->route('basket');
        }

        return view('order', compact('order'));
    }


    /**
     * Отправка Формы Подтверждения заказа
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function basketConfirm(Request $request)
    {
        $email = Auth::check() ? Auth::user()->email : $request->email;
        $success = (new basketRepository())->saveOrderBasket($request->name, $request->phone, $email);

        if ($success) {
            session()->flash('success', __('basket.order_confirmed'));
        } else {
            session()->flash('warning', 'Mistake!!');
        }

        Order::eraseOrderSum();
        return redirect()->route('index');
    }



    /**
     * Добавление товара в корзину
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function basketAdd(Product $product)
    {
        $basket = new basketRepository(true);
        $result = $basket->addProduct($product);

        if ($result){
            session()->flash('success', 'Добавлен товар '. $product->name);
        } else{
            session()->flash('warning', 'Товар '. $product->name. ' кончился' );
        }

        return redirect()->route('basket');
    }


    /**
     * Удаление записи из корзины
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function basketRemove(Product $product)
    {
        (new basketRepository())->deleteProduct($product);

        session()->flash('warning', 'Товар удален '.$product->name);


        return redirect()->route('basket');
    }


}
