<?php

namespace App\Http\Controllers;

use App\Models\Landpoint;
use Illuminate\Http\Request;

class addLandpoint extends Controller
{
    public function addLandpoints($name, $latitude, $longitude) {
        $landpoint = new Landpoint;
        $landpoint->name = $name;
        $landpoint->latitude = $latitude;
        $landpoint->longitude = $longitude;
    }
}
