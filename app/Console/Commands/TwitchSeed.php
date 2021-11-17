<?php

namespace App\Console\Commands;

use App\Jobs\StreamsJob;
use Illuminate\Console\Command;

class TwitchSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitch:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to seed database with top 1000 live streams';

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
     */
    public function handle()
    {
        StreamsJob::dispatch(1000, 'create');
    }
}
