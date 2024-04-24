<?php

namespace App\Listeners;

use App\Events\CurrencyRatesUpdated;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendCurrencyRatesUpdatedEmail
{
  private $notificationEmail;

  public function __construct()
  {
    $this->notificationEmail = Config::get('services.notification_emails.api');
  }

  public function handle(CurrencyRatesUpdated $event): void
  {
    $emailContent = "Rates have just been updated.";

    // Send the email
    Mail::raw($emailContent, function ($message) {
        $message->to($this->notificationEmail)
                ->subject('OpenExchangeRates rates updated');
    });
  }
}
