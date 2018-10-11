<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class XdebugCommand extends Command
{

    protected $signature = 'xdebug:test';

    protected $description = 'Testing Xdebug';

    public function handle()
    {
        $test = 'rest';
        $this->doSomething('Testing!');
    }

    public function doSomething($string)
    {
        $test = 'rest';
        dd($string);
    }
}