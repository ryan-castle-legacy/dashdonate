<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Http\Controllers\TaskRunners as Tasks;
use \App\Http\Controllers\TaskRunner as Runner;

class TaskRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RunCronTasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron runner for tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		// Tasks::runDonationTasks();
		Runner::processTasks();
    }
}
