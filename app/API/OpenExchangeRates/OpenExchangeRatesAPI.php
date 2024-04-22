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
      $this->appId = Config::get('open_exchange_rates.key');
    }

    public function currencies() {
      return $this->request('GET', self::BASE_URL . '/currencies.json'); 
    }

    public function latest() {
      $data['form_params'] = [ 'app_id' => $this->appId ];
      return $this->request('GET', self::BASE_URL . '/latest.json', $data);     
    }
    
    public function timeseries($start, $end, $symbols) {
      $data['form_params'] = [ 
        'app_id' => $this->appId,
        'start' => $start,
        'end' => $end,
        'symbols' => $symbols,
      ];
      return $this->request('GET', self::BASE_URL . '/latest.json', $data);  
    }

    private function request($method, $url, $data = []) {
      $jsonData = null;
      try {
        $response = $this->client->request($method, $url, $data);
        $body = $response->getBody()->getContents();
        $jsonData = json_decode($body);
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
