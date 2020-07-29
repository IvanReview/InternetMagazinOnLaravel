<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['name', 'phone'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();//промежуточная таблица подтягивается автоматически
    }



    public function userOrder()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status',1);
    }



    //полная сумма товаров
    public function calculateFullSum()
    {
        $sum=0;
        foreach ($this->products as $product){
            $sum += $product->getPriceForCount();
        }
        return $sum;
    }

    public static function changeFullSum($changeSum)
    {
        $sum=self::getFullSum()+$changeSum;
        session(['full_order_sum' => $sum]);

    }

    public static function getFullSum()
    {
       return session('full_order_sum', 0);
    }

    public static  function eraseOrderSum()
    {
        return session()->forget('full_order_sum');

    }



    public function saveOrder($name, $phone, $email)
    {
        if ($this->status==0){
            $this->name=$name;
            $this->phone=$phone;
            $this->status=1;
            $this->save();
            session()->forget('orderId'); //delete session
            return true;
        } else {
            return false;
        }
    }
}
