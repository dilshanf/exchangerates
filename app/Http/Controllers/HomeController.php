<?php

namespace App\Http\Controllers;

use App\Models\Rates;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function rates($date)
    {
      $rates = Rates::where('date', $date)
      ->leftJoin('currency as c', 'c.id', '=', 'rates.id')
      ->get();

      return view('rates', [ 'rates' => $rates ]);
    }
}
