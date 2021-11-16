<?php

namespace Database\Seeders;

use App\Jobs\StreamsJob;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        StreamsJob::dispatch($max = 1000, 'create');
    }
}
