<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('currency:update')->daily();
Schedule::command('rates:eod_email')->dailyAt('17:00');
Schedule::command('rates:update')->hourly();