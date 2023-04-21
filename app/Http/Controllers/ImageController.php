<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Models\MissionImage;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($mission_id)
    {
        $images = QueryBuilder::for(MissionImage::where('mission_report_id', $mission_id))
            ->allowedFilters(['camera_name', 'rover_name', 'rover_status', 'created_at'])
            ->paginate(10);

        return ImageResource::collection($images);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($mission_id, Request $request)
    {
        $image = new MissionImage([
            'camera_name' => $request->camera_name,
            'rover_name' => $request->rover_name,
            'img' => $request->img,
            'rover_status' => $request->rover_status,
            'mission_report_id' => $mission_id,
        ]);
        $image->save();

        return ImageResource::make($image);
    }

    /**
     * Display the specified resource.
     */
    public function show($mission_id, string $id)
    {
        $correct_id = MissionImage::where('mission_report_id', $mission_id)->get()->where('id', $id)->first()->id;

        return ImageResource::make(MissionImage::find($correct_id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($mission_id, Request $request, string $id)
    {
        $correct_id = MissionImage::where('mission_report_id', $mission_id)->get()->where('id', $id)->first()->id;
        $image = MissionImage::find($correct_id);
        $image->update($request->all());
        $image->save();

        return $image;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($mission_id, string $id)
    {
        $correct_id = MissionImage::where('mission_report_id', $mission_id)->get()->where('id', $id)->first()->id;

        return MissionImage::destroy($correct_id);
    }
}
