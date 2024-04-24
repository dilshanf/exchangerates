<?php

namespace App\Http\Controllers;

use App\Models\Rates;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
  public function rates(Request $request)
  {
    $rates = [];
    $error = '';
    try {
      $request->validate([
        'date' => 'required|date_format:Y-m-d'
      ]);

      $date = $request->input('date');

      $rates = Rates::where('date', $date)
        ->leftJoin('currency as c', 'c.id', '=', 'rates.id')
        ->get();

    } catch (ValidationException $e) {
      $error = $e->getMessage();
    }

    return view('rates', [
      'rates' => $rates, 
      'error' => $error 
    ]);
  }
}
