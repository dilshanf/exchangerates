<?php

namespace App\Console\Commands\Notifications;

use App\Events\EndOfDayRatesEmail;
use App\Models\Rates;
use Illuminate\Console\Command;

class EndOfDayRates extends Command
{
    protected $signature = 'rates:eod_email';
    protected $description = 'Sned end of day currency rates csv report email';

    public function handle()
    {
      $date =  date('Y-m-d');
      $date = '2024-04-22';
      $todaysRates = Rates::where('date', $date)
        ->leftJoin('currency as c', 'c.id', '=', 'rates.id')
        ->get();

      $this->sendEmail($todaysRates);
    }

    
  public function sendEmail($todaysRates)
  {
    $tmpDir = sys_get_temp_dir();
    $csvFileName = $tmpDir . '/rates.csv';

    $handle = fopen($csvFileName, 'w');
    fputcsv($handle, ['ID', 'Code', 'Name', 'Price']); // Add more headers as needed

    foreach ($todaysRates as $rate) {
      fputcsv($handle, [$rate->id, $rate->code, $rate->name, $rate->rate]); // Add more fields as needed
    }

    fclose($handle);

    event(new EndOfDayRatesEmail($csvFileName));
  }
}
