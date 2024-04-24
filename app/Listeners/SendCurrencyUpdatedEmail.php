<?php

namespace App\Listeners;

use App\Events\CurrencyUpdated;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendCurrencyUpdatedEmail
{
  private $notificationEmail;

  public function __construct()
  {
    $this->notificationEmail = Config::get('services.notification_emails.api');
  }

  public function handle(CurrencyUpdated $event): void
  {
    $emailContent = "Currencies have just been updated.";

    // Send the email
    Mail::raw($emailContent, function ($message) {
        $message->to($this->notificationEmail)
                ->subject('OpenExchangeRates currencies updated');
    });
  }
}
