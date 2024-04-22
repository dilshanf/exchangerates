<?php

namespace App\Jobs;

use App\Models\Rates;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCurrencyRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $key;
    protected $data;

    public function __construct($key, $data)
    {
      $this->key = $key;
      $this->data = $data;
    }

    public function handle(): void
    {
      Rates::updateOrCreate($this->key, $this->data);
    }
}
