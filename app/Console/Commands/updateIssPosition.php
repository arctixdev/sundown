<?php

namespace App\Console\Commands;

use App\Models\Landpoint;
use App\Services\IssService;
use App\Traits\HelperTraits;
use Illuminate\Console\Command;

class updateIssPosition extends Command
{
    use HelperTraits;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-iss-position';

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
        $iss = new IssService;
        $timestamp = $iss->getTimestamp();
        $location = $iss->getLocation($timestamp);
        $landpoint = $this->findClosestLandingSpot();
        $landpoint_id = Landpoint::where('name', 'LIKE', $landpoint['name'])->first()->id;
        $distance = $landpoint["distance"];
        $this->addIssPosititon($timestamp, $location->getLat(), $location->getLng(), $distance, $landpoint_id);
    }
}
