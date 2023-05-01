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
    protected $signature = 'iss:best-land-time {landpoint?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns the best time to land in the next couple of days for a specific landpoint';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $weather = new WeatherService();
        $landpoint = $this->argument('landpoint');
        $landpoint = [];
        $landpoint['name'] = $landpoint;
        if (! $landpoint) {
            $landpoint = $this->findClosestLandingSpot();
            $this->info("No landpoint specified. Using the closest one: {$landpoint['name']}");
        }
        $result = $weather->bestInTheNext24Hours($landpoint);
        $this->info("The best time to land at {$landpoint['name']} in the next few days is at {$result[0]}. It will be {$result[1]}°C");
    }
}
