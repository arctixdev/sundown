<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Location\Coordinate;

class getIssLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-iss-location {timestamp}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get iss location at given timestamp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timestamp = $this->argument('timestamp');
        $client = new Client();
        $api_response = $client->get("https://api.wheretheiss.at/v1/satellites/25544/positions?timestamps={$timestamp}");
        $response = strval($api_response->getBody());
        $response_json = get_object_vars(json_decode($response)[0]);
        $latitude = $response_json['latitude'];
        $longitude = $response_json['longitude'];
        $coordinate = new Coordinate($latitude, $longitude);
        $this->info(var_export($coordinate));
    }
}
