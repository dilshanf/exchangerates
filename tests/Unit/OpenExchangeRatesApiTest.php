<?php

namespace Tests\Unit;

use App\API\OpenExchangeRates\OpenExchangeRatesAPI;
use Illuminate\Support\Facades\Config;
use Mockery;
use Illuminate\Foundation\Testing\TestCase;

class OpenExchangeRatesApiTest extends TestCase
{
  private $api;

  protected function setUp(): void
  {
    parent::setUp();
    $this->api = new OpenExchangeRatesAPI();
  }

  protected function tearDown(): void
  {
    parent::tearDown();
    Mockery::close();
  }

  // Currency updater
  public function test_it_can_get_list_of_currencies()
  {
    $result = $this->api->currencies();

    $this->assertIsArray($result);
    $this->assertGreaterThanOrEqual(3, count($result));

    foreach ($result as $currency => $name) {
      $this->assertIsString($currency);
      $this->assertIsString($name);
    }
  }

  // Currency rate updater
  public function test_it_can_get_list_of_latest_rates()
  {
    $symbols = Config::get('services.open_exchange_rates.list');
    $result = $this->api->latest($symbols);

    $this->assertIsArray($result);
    $this->assertGreaterThanOrEqual(3, count($result));

    foreach ($result as $currency => $rate) {
      $this->assertIsString($currency);
      $this->assertIsNumeric($rate);
    }
  }
}
