<?php

namespace App\Console\Commands;

use App\API\OpenExchangeRates\OpenExchangeRatesAPI;
use App\Jobs\UpdateCurrencyRatesJob;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CurrencyRateUpdater extends Command
{
    protected $signature = 'rates:update';
    protected $description = 'Update rates table with api data';

    private $api;

    public function handle()
    {
      $symbols = Config::get('services.open_exchange_rates.list');

      $this->api = new OpenExchangeRatesAPI();

      $ccyData = $this->api->latest($symbols);

      $today = Carbon::now();
      $tod = $today->format('Y-m-d');

      foreach ($ccyData as $ccy => $rate) {

        if (is_string($ccy) && strlen($ccy) >= 1 && strlen($ccy) <= 3) {
         
          $ccyRec = Currency::where('code', $ccy)->first();

          if ($ccyRec !== null) {

            $key = [ 'id' => $ccyRec->id, 'date' => $tod ];
            $data = [ 'rate' => $rate ];

            dispatch(new UpdateCurrencyRatesJob($key, $data));
          } else {
            Log::error('Currency code not found in DB. Code: ' . $ccy);
          }
        } else {
          Log::error('Invalid CCY code: ' . $ccy);
        }
      }
    }
}
