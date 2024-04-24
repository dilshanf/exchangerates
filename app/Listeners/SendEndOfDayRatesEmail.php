<?php

namespace App\Listeners;

use App\Events\EndOfDayRatesEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendEndOfDayRatesEmail
{
  private $notificationEmail;

  public function __construct()
  {
    $this->notificationEmail = Config::get('services.notification_emails.api');
  }

  public function handle(EndOfDayRatesEmail $event): void
  {
    $emailContent = "Daily currency rates report attached.";
    $filename = $event->csvFileName;
    // Send the email
    Mail::raw($emailContent, function ($message) use ($filename) {
        $message->to($this->notificationEmail)
            ->subject('OpenExchangeRates currency rates daily report')
            ->attach($filename);
    });
  }
}
