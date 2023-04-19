<?php

namespace App\Services;

use App\Traits\HelperTraits;
use Carbon\Carbon;
use GuzzleHttp\Client;

class WeatherService {
    use HelperTraits;
    public function getHourly($latitude, $longitude) {
        $client = new Client();
        $api_response = $client->get("https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&hourly=temperature_2m");
        $response = json_decode(strval($api_response->getBody()));
        return $response;
    }

    public function getCurrent($latitude, $longitude) {
        $api_response = $this->getHourly($latitude, $longitude);
        $hour = Carbon::now()->hour;
        return $api_response->hourly->temperature_2m[$hour];
    }

    public function getCurrentAtLandpoint($landpoint) {
        $landpointObj = $this->getLandpoint($landpoint);
        return $this->getCurrent($landpointObj->latitude,$landpointObj->longitude);
    }

    public function bestInTheNext24Hours($landpoint) {
        $landpoint = $this->getLandpoint($landpoint);
        $temps = $this->getHourly($landpoint->latitude,$landpoint->longitude);
        $lowestKey = -1;
        $lowestTemp = 999;
        foreach ($temps->hourly->temperature_2m as $key => $temp) {
            if ($temp < $lowestTemp) {
                $lowestTemp = $temp;
                $lowestKey = $key;
            }
        }
        $time = $temps->hourly->time[$lowestKey];
        return [$time, $lowestTemp];
    }
}
