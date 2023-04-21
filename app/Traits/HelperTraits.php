<?php

namespace App\Traits;

use App\Models\IssPosition;
use App\Models\Landpoint;
use App\Models\User;
use App\Services\IssService;
use Illuminate\Support\Facades\Hash;
use Location\Coordinate;
use Location\Distance\Vincenty;

trait HelperTraits
{
    /**
     * Calculate distance between two coordinates
     */
    public function calculateDistance($cord_from, $cord_to)
    {
        $calculator = new Vincenty();

        return $calculator->getDistance($cord_from, $cord_to);
    }

    /**
     * Helper function to help adding a user
     */
    public function addUser($first_name, $last_name, $code_name, $username, $email, $password, $avatar)
    {
        $user = new User;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->code_name = $code_name;
        $user->username = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->avatar = $avatar;
        $user->save();

        return $user;
    }

    /**
     * Helper function to help adding a landpoint
     */
    public function addLandpoint($name, $latitude, $longitude)
    {
        $landpoint = new Landpoint;
        $landpoint->name = $name;
        $landpoint->latitude = $latitude;
        $landpoint->longitude = $longitude;
        $landpoint->save();

        return $landpoint->id;
    }

    /**
     * Helper function to help adding a Iss Posistion
     */
    public function addIssPosititon($timestamp, $latitude, $longitude, $distance, $landpoint_id)
    {
        $posisiton = new IssPosition;
        $posisiton->timestamp = $timestamp;
        $posisiton->latitude = $latitude;
        $posisiton->longitude = $longitude;
        $posisiton->distance = $distance;
        $posisiton->landpoint_id = $landpoint_id;
        $posisiton->save();
    }

    /**
     * Parse a landpoint
     * Convert it from database model object to Name and coordinates
     */
    public function parseLandpoint(Landpoint $landpoint)
    {
        $name = $landpoint->name;
        $coordinate = new Coordinate($landpoint->latitude, $landpoint->longitude);

        return ['name' => $name, 'coordinate' => $coordinate];
    }

    /**
     * Get all landpoints from database and parse them
     */
    public function getLandpoints()
    {
        $db_landpoints = Landpoint::all();
        $landpoints = [];
        foreach ($db_landpoints as $db_landpoint) {
            $landpoint = $this->parseLandpoint($db_landpoint);
            $landpoints[$landpoint['name']] = $landpoint['coordinate'];
        }

        return collect($landpoints);
    }

    /**
     * Find the current closest landingspot for the ISS
     */
    public function findClosestLandingSpot()
    {
        $issService = new IssService();
        $landpoints = $this->getLandpoints();
        $iss_location = $issService->getCurrentLocation();

        $landpoints->each(function ($value, $key) use ($iss_location, $landpoints) {
            $distance = $this->calculateDistance($iss_location, $value);
            $landpoints[$key]->distance = $distance;
        });

        $landpointsSorted = $landpoints->sortBy('distance');

        return ['name' => $landpointsSorted->keys()->first(), 'location' => $landpointsSorted->first()];
    }

    /**
     * Get a landpoint by name
     */
    public function getLandpoint($name)
    {
        return Landpoint::where('name', '=', $name)->first();
    }
}
