<?php

namespace App\API\OpenExchangeRates;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class OpenExchangeRatesAPI
{
    const BASE_URL = 'https://openexchangerates.org/api/';

    private $client;
    private $appId;

    public function __construct() {
      $this->client = new Client();
      $this->appId = Config::get('services.open_exchange_rates.key');
    }

    public function currencies() {
      return $this->request('GET', self::BASE_URL . '/currencies.json'); 
    }

    public function latest($symbols = null) {
      $sym = $symbols === null ? '' : $symbols;
      $url = self::BASE_URL . '/latest.json' . '?app_id=' . $this->appId . '&symbols=' . $sym;
      $response = $this->request('GET', $url);

      return isset($response['rates']) && is_array($response['rates']) ? $response['rates'] : null;
    }
    
    public function timeseries($start, $end, $symbols = null) {
      $sym = $symbols === null ? '' : $symbols;
      $url = self::BASE_URL . '/latest.json' . '?app_id=' . $this->appId . '&start=' . $start . '&end=' . $end . '&symbols=' . $sym;

      return $this->request('GET', self::BASE_URL . '/time-series.json');  
    }

    private function request($method, $url) {
      $jsonData = null;
      try {
        $data['headers']['Accept'] = 'application/json';
        $response = $this->client->request($method, $url);
        $body = $response->getBody()->getContents();
        $jsonData = json_decode($body, true);
      } catch (GuzzleException $e) {
        $resCode = $e->getCode();
        if ($resCode === '400') {
          Log::error('Unsupported base currency');
        } elseif ($resCode === '401') {
          Log::error('Invalid API key');
        } elseif ($resCode === '403' || $resCode === '429') {
          Log::error('Rate limited');
        } elseif ($resCode === '404') {
          Log::error('404 not found');
        } else {
          // unhandled exception
          Log::error('Unhandled code : ' . $resCode);
        }
      }

      return $jsonData;
    }
}
