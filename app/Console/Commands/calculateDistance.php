<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Location\Distance\Vincenty;

class calculateDistance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-distance {cord_from} {cord_to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate distance between two coordinates';

    /**
     * Execute the console command.
     */
    public function handle($cord_from, $cord_to)
    {
        $calculator = new Vincenty();
        $this->info($calculator->getDistance($cord_from, $cord_to));
    }
}
