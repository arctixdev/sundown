<?php

namespace App\Console\Commands;

use App\Traits\IssPositionTrait;
use Location\Coordinate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class findClosestLandingSpot extends Command
{
    use IssPositionTrait;
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
    protected $description = 'Find the closest landingspot and save it to the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clostestLandingPoint = $this->findClosestLandingSpot();
        $this->info(var_dump($clostestLandingPoint));
    }
}
