<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\BasketRepository;
use App\Repositories\FilterRepository;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index(Request $request)
    {

        $productsFiltered = Product::with('category');// возвращается объект билдера  к которому можно применить условия для поиска и уже потом метод пагинейт

        //фильтры
        $products = (new FilterRepository($productsFiltered, $request))->apply()->paginate(6);

        return view('index', compact('products'));
    }


    //отображение всех категорий
    public function categories()
    {
        $categories=Category::get();
        return view('categories', compact('categories'));
    }


    //отображение 1 категории вместе с продуктами
    public function category($categoryCode){
       $category=Category::where('code', $categoryCode)->with('products')->first();

        return view('category', compact('category'));
    }


    //отображение 1 продукта
    public function product($categories, $product=null)//если параметр не обязателен нужно давать дефольное значение
    {
        $category = Category::where('code', $categories)->first();
        $product = Product::where('code', $product)->first();

        return view('product' , compact('category','product'));
    }
}
