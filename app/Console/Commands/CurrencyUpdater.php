<?php

namespace App\Console\Commands;

use App\API\OpenExchangeRates\OpenExchangeRatesAPI;
use App\Jobs\UpdateCurrencyJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CurrencyUpdater extends Command
{
    protected $signature = 'currency:update';

    protected $description = 'Update currencies table with api data';

    private $api;

    public function handle()
    {
      $this->api = new OpenExchangeRatesAPI();

      $ccyData = $this->api->currencies();

      foreach ($ccyData as $ccy => $ccyName) {

        if (is_string($ccy) && strlen($ccy) <= 3) {
         
          $key = [ 'code' => $ccy ];
          $data = [ 'name' => $ccyName ];

          dispatch(new UpdateCurrencyJob($key, $data));
        } else {
          Log::error('Invalid CCY code: ' . $ccy);
        }
      }
    }
}
