<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;
    protected $baseURL = 'https://free.currconv.com/api/v7';


    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }


    public function convert(string $from, string $to, $amount = 1): float
    {
        $q = "{$from}_{$to}";
        //Method 1
        $response = Http::baseUrl($this->baseURL)->get('/convert', [
            'q' => $q,
            'compact' => 'y',
            'apiKey' => "$this->apiKey"
        ]);


        $result = $response->json();
        return $result[$q]['val'] * $amount;
        /*
         Method 2
        $response = file_get_contents("$this->baseURL/convert?q={$q}&compact=y&apiKey={$this->apiKey}");
        $obj=json_decode($response, true);
        $val = $obj["$q"];
       return $val['val'] * $amount;
        */
    }
}
