<?php

namespace App\Console\Commands;

use App\Jobs\StreamsJob;
use Illuminate\Console\Command;

class TwitchUpdateStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitch:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update database with top 100 live streams';

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
        StreamsJob::dispatch($max = 100, 'update');
    }
}
