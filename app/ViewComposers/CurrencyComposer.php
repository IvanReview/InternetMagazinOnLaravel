<?php


namespace App\ViewComposers;


use App\Repositories\CurrencyConversion;
use Illuminate\View\View;

class CurrencyComposer
{
    public function compose(View $view)
    {
        $currencies = CurrencyConversion::getCurrencies();
        $view->with('currencies', $currencies);

    }

}
