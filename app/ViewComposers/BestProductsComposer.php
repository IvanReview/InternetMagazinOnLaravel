<?php


namespace App\ViewComposers;


use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class BestProductsComposer
{
    public function compose(View $view)
    {

        /*$bestProductIds = Order::get()->map->products->flatten()->map->pivot->mapToGroups(function ($pivot) {
            return [$pivot->product_id => $pivot->count ];
        })->map->sum()->sortByDesc(null)->take(3)->keys()->toArray();*/

        //верхняя часть доступ к промежуточной таблице order_product
        $bestProductIds = Order::get()->map->products->flatten()->map->pivot
            ->groupBy('product_id')->map->sum('count')->sort()->reverse()->take(3)->keys();

       /* dd($bestProductIds);*/


        $bestProducts = Product::whereIn('id', $bestProductIds)->get();
        $view->with('bestProducts', $bestProducts);
    }

}
