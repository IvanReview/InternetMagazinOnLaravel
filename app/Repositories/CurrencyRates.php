<?php

namespace App\Repositories;


use Exception;
use GuzzleHttp\Client;

class CurrencyRates
{
    public static function getRates()
    {
        $baseCurrency = CurrencyConversion::getBaseCurrency();
        $url = config('currency_rates.api_url') . '?base=' . $baseCurrency->code;

        // методыGuzzle
        $client = new Client();
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() !==200) {
            throw new Exception('Проблема с сервисом валют');
        }

        $rates = json_decode($response->getBody()->getContents(), true)['rates'];

        foreach (CurrencyConversion::getCurrencies() as $currency){
            if (!$currency->isMain()){
                if (!isset($rates[$currency->code])){
                    throw new Exception('Проблема с сервисом валют' . $currency->code);
                } else {
                    $currency->update(['rate'=> $rates[$currency->code]]);
                    $currency->touch();
                }
            }
        }

    }


}
