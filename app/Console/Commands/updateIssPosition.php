<?php

namespace App\Console\Commands;

use App\Models\Landpoint;
use App\Services\IssService;
use App\Traits\HelperTraits;
use Carbon\Carbon;
use Illuminate\Console\Command;

class updateIssPosition extends Command
{
    use HelperTraits;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iss:update-position';

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
        $timestamp = intval(Carbon::now()->timestamp);
        $location = $iss->getLocation($timestamp);
        $landpoint = $this->findClosestLandingSpot();
        $landpoint_id = Landpoint::where('name', 'LIKE', $landpoint['name'])->first()->id;
        $distance = $landpoint['location']->distance;
        $this->addIssPosititon($timestamp, $location->getLat(), $location->getLng(), $distance, $landpoint_id);
    }
}
