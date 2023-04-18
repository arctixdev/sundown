<?php

namespace App\Console\Commands;

use Location\Coordinate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class findClosestLandingSpot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:find-closest-landing-spot';

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
        $landpoints = [
            "Europe" => new Coordinate(55.68474022214539, 12.50971483525464),
            "China" => new Coordinate(41.14962602664463, 119.33727554032843),
            "America" => new Coordinate(40.014407426017335, -103.68329704730307),
            "Africa" => new Coordinate(-21.02973667221353, 23.77076788325546),
            "Australia" => new Coordinate(-33.00702098732439, 117.83314818861444),
            "India" => new Coordinate(19.330540162912126, 79.14236662251713),
            "Argentina" => new Coordinate(-34.050351176517886, -65.92682965568743),
        ];
        Artisan::call('app:get-current-iss-location');
        $iss_location = Artisan::output();
        dump($iss_location);
        $smallest_distance = [
            "distance" => 999999999999999999,
            "name" => "None"
        ];
        foreach ($landpoints as $name => $landpoint) {
            $distance = Artisan::call('app:calculate-distance', ['cord_from' => $iss_location, 'cord_to' => $landpoint]);
            if ($distance < $smallest_distance["distance"]) {
                error_log("New smallest distance landpoint: {$name}");
                error_log(number_format($distance, "10"));
                $smallest_distance["distance"] = $distance;
                $smallest_distance["name"] = $name;
            }
        }
        $this->info($smallest_distance);
    }
}
