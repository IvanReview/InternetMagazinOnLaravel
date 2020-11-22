<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFilterRequest;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscription;
use App\Repositories\BasketRepository;
use App\Repositories\CurrencyRates;
use App\Repositories\FilterRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
    public function product($categories, $productCode)//если параметр не обязателен нужно давать дефольное значение
    {
        $category = Category::where('code', $categories)->first();
        $product = Product::where('code', $productCode)->firstOrFail();

        return view('product' , compact('category','product'));
    }


    public function subscribe(SubscriptionRequest $request, Product $product)
    {
        Subscription::create(
            [
                'email'=>$request->email,
                'product_id'=>$product->id,
            ]
        );
        return redirect()->back()->with('success', 'Спасибо, мы свяжемся с вами при поступлении товара');
    }

    /**
     * @param $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLocale($locale)
    {
        $availableLocales = ['ru', 'en'];
        if (!in_array($locale, $availableLocales)){
            $locale = config('app.locale');

        }
        //локаль в миддлваре setLocale
        session(['locale'=>$locale]);
        App::setLocale($locale);

        return redirect()->back();
    }

    /**
     * @param $currencyCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeCurrency($currencyCode)
    {
        $currency = Currency::byCode($currencyCode)->firstOrFail();
        session(['currency'=>$currency->code]);
        return redirect()->back();
    }
}
