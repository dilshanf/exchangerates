<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('currency:update')->daily();
Schedule::command('rates:update')->hourly();