<?php

/*
 * This file is part of the overtrue/laravel-options.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Overtrue\LaravelOptions\Console\Commands;

use Illuminate\Console\Command;
use Overtrue\LaravelOptions\Facade as Option;

class SetOption extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'option:set
                            {key : Option key}
                            {value : Option value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an option.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Option::set($this->argument('key'), $this->argument('value'));

        $this->info('Option updated.');
    }
}
