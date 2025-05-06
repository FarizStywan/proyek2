<?php

namespace App\Bootstrap;

use Illuminate\Foundation\Console\Kernel as BaseConsoleKernel;

class ConsoleKernel extends BaseConsoleKernel
{
    protected function commands()
    {
        $this->load(__DIR__.'/../Console/Commands');
    }
}
