<?php

namespace App\Traits;

use App\Console\Commands\getCurrentIssLocation;
use App\Models\IssPosition;
use App\Models\Landpoint;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Location\Coordinate;
use Location\Distance\Vincenty;

trait IssPositionTrait {
    public function getIssLocation($timestamp) {
        $client = new Client();
        $api_response = $client->get("https://api.wheretheiss.at/v1/satellites/25544/positions?timestamps={$timestamp}");
        $response = strval($api_response->getBody());
        $response_json = get_object_vars(json_decode($response)[0]);
        $latitude = $response_json['latitude'];
        $longitude = $response_json['longitude'];
        return new Coordinate($latitude, $longitude);
    }

    public function getCurrentIssLocation() {
        return $this->getIssLocation(Carbon::now()->timestamp);
    }

    public function getTimestamp() {
        return intval(Carbon::now()->timestamp);
    }

    public function calculateDistance($cord_from, $cord_to) {
        $calculator = new Vincenty();
        return $calculator->getDistance($cord_from, $cord_to);
    }

    public function addLandpoint($name, $latitude, $longitude) {
        $landpoint = new Landpoint;
        $landpoint->name = $name;
        $landpoint->latitude = $latitude;
        $landpoint->longitude = $longitude;
        $landpoint->save();
        return $landpoint->id;
    }

    public function addIssPosititon($timestamp, $latitude, $longitude, $distance, $landpoint_id) {
        $posisiton = new IssPosition;
        $posisiton->timestamp = $timestamp;
        $posisiton->latitude = $latitude;
        $posisiton->longitude = $longitude;
        $posisiton->distance = $distance;
        $posisiton->landpoint_id = $landpoint_id;
        $posisiton->save();
    }

    public function findClosestLandingSpot() {
        $landpoints = [
            "Europe" => new Coordinate(55.68474022214539, 12.50971483525464),
            "China" => new Coordinate(41.14962602664463, 119.33727554032843),
            "America" => new Coordinate(40.014407426017335, -103.68329704730307),
            "Africa" => new Coordinate(-21.02973667221353, 23.77076788325546),
            "Australia" => new Coordinate(-33.00702098732439, 117.83314818861444),
            "India" => new Coordinate(19.330540162912126, 79.14236662251713),
            "Argentina" => new Coordinate(-34.050351176517886, -65.92682965568743),
        ];
        $iss_location = $this->getCurrentIssLocation();
        $closestLandingspot = [
            "distance" => 999999999999999999,
            "name" => "None"
        ];
        foreach ($landpoints as $name => $landpoint) {
            $distance = $this->calculateDistance($iss_location, $landpoint);
            if ($distance < $closestLandingspot["distance"]) {
                $closestLandingspot["distance"] = $distance;
                $closestLandingspot["name"] = $name;
            }
        }
        return $closestLandingspot;
    }
}
