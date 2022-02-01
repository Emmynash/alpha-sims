<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Addassignment;

class cronNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check if the notification has expired';

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
        //
        $assignment = Addassignment::find(5);
        $assignment->schoolid = 4;
        $assignment->save();
    }
}
