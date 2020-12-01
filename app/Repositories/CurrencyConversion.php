<?php


namespace App\Repositories;


use App\Models\Currency;
use Carbon\Carbon;

class CurrencyConversion
{
    protected static $container;
    const DEFAULT_CURRENCY_CODE = 'RUB';

    /**
     *
     */
    public static function loadContainer()
    {
        if (is_null(self::$container)){
            $currencies = Currency::get();
            foreach ($currencies as $currency) {
                self::$container[$currency->code] = $currency;
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    public static function getCurrencyFromSession()
    {
        return session('currency', self::DEFAULT_CURRENCY_CODE);
    }

    /**
     * @return mixed
     */
    public static function getCurrentCurrencyFromSession()
    {
        self::loadContainer();
        $currencyCode = self::getCurrencyFromSession();
        foreach (self::$container as $currency){
            if ($currency->code === $currencyCode){
                return $currency;
            }
        }
    }


    /**
     * @return mixed
     */
    public static function getCurrencies()
    {
        self::loadContainer();
        return self::$container;
    }


    /**
     * @param $sum
     * @param string $originCurrencyCode
     * @param null $targetCurrencyCode
     * @return float|int
     * @throws \Exception
     */
    public static function convert($sum, $originCurrencyCode = self::DEFAULT_CURRENCY_CODE, $targetCurrencyCode = null)
    {
        self::loadContainer();
        $originCurrency = self::$container[$originCurrencyCode];

        if ($originCurrency->code != self::DEFAULT_CURRENCY_CODE) {
            //еси валюта не обновлялась обновиь
            if ($originCurrency->rate !=0 || $originCurrency->updated_at->startOfDay() != Carbon::now()->startOfDay()){
                CurrencyRates::getRates();
                self::loadContainer();
                $originCurrency = self::$container[$originCurrencyCode];

            }
        }
        if (is_null($targetCurrencyCode)) {
            $targetCurrencyCode = self::getCurrencyFromSession();
        }
        $targetCurrency = self::$container[$targetCurrencyCode];
        if ($originCurrency->code != self::DEFAULT_CURRENCY_CODE){
            if ($targetCurrency->rate == 0 || $targetCurrency->updated_at->startOfDay() != Carbon::now()->startOfDay()){
                CurrencyRates::getRates();
                self::loadContainer();
                $originCurrency = self::$container[$targetCurrencyCode];

            }
        }

        return $sum / $originCurrency->rate * $targetCurrency->rate;
    }


    /**
     * @return mixed
     */
    public static function getCurrencySymbol()
    {
        self::loadContainer();
        $currencyFromSession = self::getCurrencyFromSession();
        $currency  = self::$container[$currencyFromSession];
       return $currency->symbol;
    }

    /**
     * @return mixed
     */
    public static function getBaseCurrency()
    {
        self::loadContainer();

        foreach (self::$container as $code => $currency){
                if ($currency->isMain()) {
                    return $currency;
                }
        }

    }

}
