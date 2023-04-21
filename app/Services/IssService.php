<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Location\Coordinate;

class IssService
{
    /**
     * Get location of iss on a specific timestamp
     */
    public function getLocation($timestamp)
    {
        $client = new Client();
        $api_response = $client->get("https://api.wheretheiss.at/v1/satellites/25544/positions?timestamps={$timestamp}");
        $response = strval($api_response->getBody());
        $response_json = get_object_vars(json_decode($response)[0]);
        $latitude = $response_json['latitude'];
        $longitude = $response_json['longitude'];

        return new Coordinate($latitude, $longitude);
    }

    /**
     * Get current iss posistion
     */
    public function getCurrentLocation()
    {
        return $this->getLocation(Carbon::now()->timestamp);
    }
}
