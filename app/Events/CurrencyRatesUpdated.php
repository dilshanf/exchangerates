<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CurrencyRatesUpdated
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $broadcastName = 'currency_rates_updated';

  public function __construct()
  {
  }

  public function broadcastOn(): array
  {
    return [
      new PrivateChannel('currency_rates_updated'),
    ];
  }
}
