<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
use App\Traits\HelperTraits;
use Illuminate\Console\Command;

class getWeather extends Command
{
    use HelperTraits;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-current-weather {landpoint?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get current weather at a specific landpoint ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $weather = new WeatherService();
        $landpoint = $this->argument('landpoint');
        if (! $landpoint) {
            $landpoint = $this->findClosestLandingSpot()['name'];
            $this->info("No landpoint specified. Using the closest one: {$landpoint}");
        }
        $currentWeather = $weather->getCurrentAtLandpoint($landpoint);
        $this->info("Its currently {$currentWeather}°C at the {$landpoint} landpoint!");
    }
}
