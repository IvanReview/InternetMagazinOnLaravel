<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Отображение страницы товаров
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $products= Product::paginate(10);
        return view('auth.products.index', compact('products'));
    }

    /**
     * Отображение формы создания товара
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        $properties = Property::get();
        return view('auth.products.create', compact('categories', 'properties'));

    }

    /**
     * Сохранение нового продукта в базе
     *
     * @param ProductsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        //Получаем данные из формы
        $data=$request->all();

        //если поле code не заполнено создаем автоматически
        if (empty($data['code'])) {
            $data['code'] = Str::slug($data['name'], '-');
        }

        if ($request->has('image')){
        //получение пути к файлу и сохранение (store) в папку
        $path=$request->file('image')->store('products');
        //переназначение пути
        $data['image']=$path;
        }

        //переопределение значения чекбокса с 'on' на 1 в мутаторе, который лежит в модели
        //создаем новую запись
        $success=Product::create($data);
        if ($success){
            session()->flash('success', 'Товар успешно создан!');
            return redirect()->route('products.index');
        }

        return redirect()->route('products.index');
    }

    /**
     * Подробное отображение продукта
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('auth.products.show', compact('product'));
    }

    /**
     * Отображение формы для редактирования продукта
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $categories = Category::get();
        $properties = Property::get();
        return view('auth.products.edit', compact('product', 'categories', 'properties'));
    }

    /**
     * Обновление продукта в базе
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, Product $product)
    {

        //получаем данные из формы
        $data = $request->except('property_id');
        //если code не заполнено создаем автоматически
        if (empty($data['code'])) {
            $data['code'] = Str::slug($data['name'], '-');
        }

        //переопределение значения чекбокса с 'on' на 1 в мутаторе, лежит в модели, если перемен не существует(чебокс не нажат) мутатор не срабатывает
        foreach (['new', 'hit','recommend'] as $fieldName){
            if (!isset($data[$fieldName])) {
                $data[$fieldName] = 0;
            }
        }

        //картинка
        if($request->has('image')){
            //удаляем старое изображение
            Storage::delete($product->image);
            //получение пути к файлу и store сохранение в папку
            $path=$request->file('image')->store('products');
            //переназначение пути
            $data['image']=$path;
        }

        /*dd($request->property_id);*/
        $product->properties()->sync($request->property_id);

        //обновляеем данные
        $success=$product->update($data);
        if ($success){
            session()->flash('success', 'Товар успешно обновлен!');
            return redirect()->route('products.index');
        }
    }

    /**
     * Удаление продукта из базы
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
