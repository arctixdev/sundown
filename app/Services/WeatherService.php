<?php

namespace App\Services;

use App\Traits\HelperTraits;
use Carbon\Carbon;
use GuzzleHttp\Client;

class WeatherService
{
    use HelperTraits;

    /**
     * Get weather forecast for the next couple of hours
     */
    public function getHourly($latitude, $longitude)
    {
        $client = new Client();
        $api_response = $client->get("https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&hourly=temperature_2m");
        $response = json_decode(strval($api_response->getBody()));

        return $response;
    }

    /**
     * Get current temperature for specific cords
     */
    public function getCurrent($latitude, $longitude)
    {
        $api_response = $this->getHourly($latitude, $longitude);
        $hour = Carbon::now()->hour;

        return $api_response->hourly->temperature_2m[$hour];
    }

    /**
     * Get current temperature for specific landpoint
     */
    public function getCurrentAtLandpoint($landpoint)
    {
        $landpointObj = $this->getLandpoint($landpoint);

        return $this->getCurrent($landpointObj->latitude, $landpointObj->longitude);
    }

    /**
     * Find the time with lowest temperature in the next days at a specific landpoint
     */
    public function bestInTheNext24Hours($landpoint)
    {
        $landpoint = $this->getLandpoint($landpoint['name']);
        $temps_dat = $this->getHourly($landpoint->latitude, $landpoint->longitude);
        $temps = $temps_dat->hourly->temperature_2m;
        $lowest_temp = min($temps);
        $lowest_temp_key = array_search($lowest_temp, $temps);
        $time = $temps_dat->hourly->time[$lowest_temp_key];

        return [$time, $lowest_temp];
    }
}
