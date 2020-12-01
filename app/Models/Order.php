<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [
        '_token'
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['count', 'price'])->withTimestamps();//промежуточная таблица подтягивается автоматически
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }



    public function userOrder()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status',1);
    }



    public function getFullSum()
    {
        $sum = 0;
        foreach ($this->products as $product) {
            $sum += $product->price * $product->countInOrder;
        }
        return $sum;
    }


    public function saveOrder($name, $phone, $email)
    {

        $this->name=$name;
        $this->phone=$phone;
        $this->status=1;
        $this->sum = $this->getFullSum();
        $products = $this->products;
        $this->save();

      /*  dd($products);*/
        foreach ($products as $productInOrder) {
            $this->products()->attach($productInOrder,[
                'count' => $productInOrder->countInOrder,
                'price' => $productInOrder->price,
           ]);
        }
        session()->forget('order'); //delete session
        return true;

    }
}
