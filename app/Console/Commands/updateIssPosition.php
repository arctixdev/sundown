<?php

namespace App\Console\Commands;

use App\Models\Landpoint;
use App\Traits\IssPositionTrait;
use Illuminate\Console\Command;

class updateIssPosition extends Command
{
    use IssPositionTrait;
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
        $timestamp = $this->getTimestamp();
        $location = $this->getIssLocation($timestamp);
        $landpoint = $this->findClosestLandingSpot();
        $landpoint_id = Landpoint::where('name', 'LIKE', $landpoint['name'])->first()->id;
        $distance = $landpoint["distance"];
        $this->addIssPosititon($timestamp, $location->getLat(), $location->getLng(), $distance, $landpoint_id);
    }
}
