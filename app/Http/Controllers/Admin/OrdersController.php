<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders=Order::active()->paginate(10);
        return view('auth.orders.index', compact('orders'));
    }


    public function show($id)
    {
        $order=Order::where('id', $id)->first();
        
        return view('auth.orders.show', compact('order'));
    }
    


    public function executeOrder($orderId)
    {
        $order=Order::where('id', $orderId)->first();
        $order->status=0;
        $order->save();
        return redirect()->route('home');
    }

}
