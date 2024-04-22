<?php

use Illuminate\Support\Facades\Route;

Route::get('/rates/{date}', 'App\Http\Controllers\HomeController@rates')->name('display-rates')->where('date', '[0-9]{4}-[0-9]{2}-[0-9]{2}');
