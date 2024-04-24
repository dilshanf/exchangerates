<?php

use Illuminate\Support\Facades\Route;

Route::get('/rates', 'App\Http\Controllers\HomeController@rates')->name('display-rates');
