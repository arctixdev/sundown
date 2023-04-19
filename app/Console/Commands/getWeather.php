<?php

namespace App\Console\Commands;

use App\Models\User;
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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('first_name', 'LIKE', 'Yi')->first();
        dump($user);
        $user_reports = $user->reports->first();
        dump($user_reports);
        $repport_image = $user_reports->images->first();
        dump($repport_image);
        $weather = new WeatherService();
        $landpoint = $this->argument('landpoint');
        if (!$landpoint) {
            $landpoint = $this->findClosestLandingSpot()["name"];
            $this->info("No landpoint specified. Using the closest one: {$landpoint}");
        }
        $currentWeather = $weather->getCurrentAtLandpoint($landpoint);
        $this->info("Its currently {$currentWeather}°C at the {$landpoint} landpoint!");
    }
}
