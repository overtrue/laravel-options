<?php

namespace Overtrue\LaravelOptions\Console\Commands;

use Illuminate\Console\Command;
use Overtrue\LaravelOptions\Facade as Option;

class SetOption extends Command
{
    protected $signature = 'option:set
                            {key : Option key}
                            {value : Option value}';

    protected $description = 'Create an option.';

    public function handle()
    {
        Option::set($this->argument('key'), $this->argument('value'));

        $this->info('Option updated.');
    }
}
