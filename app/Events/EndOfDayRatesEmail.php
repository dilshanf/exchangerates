<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EndOfDayRatesEmail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $csvFileName;

    public function __construct($csvFileName)
    {
      $this->csvFileName = $csvFileName;
    }

    public function broadcastOn(): array
    {
      return [
        new PrivateChannel('end_of_day_rates_email'),
      ];
    }
}
