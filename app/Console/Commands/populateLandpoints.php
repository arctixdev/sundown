<?php

namespace App\Console\Commands;

use App\Traits\IssPositionTrait;
use Illuminate\Console\Command;
use Location\Coordinate;

class populateLandpoints extends Command
{
    use IssPositionTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-landpoints';

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
        foreach ($landpoints as $name => $landpoint) {
            $this->addLandpoint($name, $landpoint->getLat(), $landpoint->getLng());
        }
    }
}
