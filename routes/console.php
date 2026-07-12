<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:clean-old-logs')->daily();
Schedule::command('app:expire-appointments')->hourly();
