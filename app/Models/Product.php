<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = [
        '_token'
    ];

    public function category(){
        return  $this->belongsTo(Category::class);
    }

    //подсчет общей стоимости (количество) одного товара
    public function getPriceForCount()
    {
        if (!is_null($this->pivot)){
            $totalPrice = $this->pivot->count * $this->price;
            return $totalPrice;
        }
        return $this->price;
    }


    public function isAvailable()
    {
        return $this->count > 0;

    }


    //Scope
    public function scopeHit($query)
    {
        return $query->where('hit',1);
    }

    public function scopeNew($query)
    {
        return $query->where('new',1);
    }

    public function scopeRecommend($query)
    {
        return $query->where('recommend',1);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }



    //мутатор, внутреннее свойство attributes для доступа к полям
    public function setNewAttribute($value)
    {
        $this->attributes['new'] = $value ? 1 : 0;
    }

    public function setHitAttribute($value)
    {
        $this->attributes['hit'] = $value ? 1 : 0;
    }

    public function setRecommendAttribute($value)
    {
        $this->attributes['recommend'] = $value ? 1 : 0;
    }



    public function isHit()
    {
        return $this->hit == 1;
    }

    public function isNew()
    {
        return $this->new == 1;
    }

    public function isRecommend()
    {
        return $this->recommend === 1;
    }
}
