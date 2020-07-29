<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\BasketRepository;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index(ProductsFilterRequest $request)
    {

        $productsQuery = Product::with('category');// возвращается объект билдера  к которому можно применить условия для поиска и уже потом метод пагинейт

        //фильтр товаров по цене
        if ($request->filled('price_from')){//filled проверяет является ли данное поле заполненым
            $productsQuery->where('price','>=', $request->price_from);
        }
        if ($request->filled('price_to')){//filled проверяет является ли данное поле заполненым
            $productsQuery->where('price','<=', $request->price_to);
        }

        foreach (['hit', 'new', 'recommend'] as $fieldName) {
            if ($request->has($fieldName)) {
                $productsQuery->$fieldName();//скоупы, прописанны в модели
            }
        }
        $order = (new basketRepository())->getOrder();

        $products=$productsQuery->paginate(6);
        return view('index', compact('products','order'));
    }


    //отображение всех категорий
    public function categories()
    {
        $order = (new basketRepository())->getOrder();
        $categories=Category::get();
        return view('categories', compact('categories', 'order'));
    }


    //отображение 1 категории вместе с продуктами
    public function category($categoryCode){
       $category=Category::where('code', $categoryCode)->with('products')->first();

        return view('category', compact('category'));
    }


    //отображение 1 продукта
    public function product($categories, $product=null)//если параметр не обязателен нужно давать дефольное значение
    {
        $order = (new basketRepository())->getOrder();
        $category = Category::where('code', $categories)->first();
        $product = Product::where('code', $product)->first();

        return view('product' , compact('category','product','order'));
    }
}
