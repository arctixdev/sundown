<?php

namespace App\Http\Controllers;

use App\Http\Resources\MissionReportResource;
use App\Models\MissionReport;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $missons = QueryBuilder::for(MissionReport::class)
            ->allowedFilters(['name', 'mission_date', 'user_id', 'lat', 'lon'])
            ->paginate(10);

        return MissionReportResource::collection($missons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $report = new MissionReport([
            'name' => $request->name,
            'description' => $request->description,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'mission_date' => $request->mission_date,
            'user_id' => $request->user_id,
        ]);
        $report->save();

        return MissionReportResource::make($report);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return MissionReportResource::make(MissionReport::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $report = MissionReport::find($id);
        $report->update($request->all());
        $report->save();

        return $report;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return MissionReport::destroy($id);
    }
}
