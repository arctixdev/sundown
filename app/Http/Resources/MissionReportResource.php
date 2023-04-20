<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'mission_date' => $this->mission_date,
            'user_id' => $this->user_id,
            'images' => ImageResource::collection($this->images),
            'user' => $this->user,
        ];
    }
}
