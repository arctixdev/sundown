<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
use App\Traits\HelperTraits;
use Illuminate\Console\Command;

class getBestTime extends Command
{
    use HelperTraits;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-best-time {landpoint?} {mode?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $weather = new WeatherService();
        $landpoint = $this->argument('landpoint');
        if (!$landpoint) {
            $landpoint = $this->findClosestLandingSpot()["name"];
            $this->info("No landpoint specified. Using the closest one: {$landpoint}");
        }
        $result = $weather->bestInTheNext24Hours($landpoint);
        $this->info("The best time to land at {$landpoint} in the next few days is at {$result[0]}. It will be {$result[1]}°C");
    }
}
