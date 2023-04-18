<?php

namespace App\Http\Controllers;

use App\Models\Landpoint;
use App\Traits\IssPositionTrait;
use Illuminate\Http\Request;
use Location\Coordinate;

class testcontroller extends Controller
{
    use IssPositionTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timestamp = $this->getTimestamp();
        $location = $this->getIssLocation($timestamp);
        $distance = $this->calculateDistance($location, new Coordinate(3.33, 3.33));
        $landpoint = $this->findClosestLandingSpot();
        $landpoint_id = Landpoint::where('name', 'LIKE', $landpoint['name'])->get()[0]->id;
        error_log($landpoint_id);
        $this->addIssPosititon($timestamp, $location->getLat(), $location->getLng(), $distance, $landpoint_id);
        return view('front', ["landpoint" => $this->findClosestLandingSpot()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
