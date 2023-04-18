<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Location\Coordinate;
use Illuminate\Support\Facades\Artisan;

class getCurrentIssLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-current-iss-location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the current iss location';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('app:get-iss-location', ['timestamp' => Carbon::now()->timestamp]);
        $output = Artisan::output();
        $this->info($output);
    }
}
