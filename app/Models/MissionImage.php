<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'camera_name',
        'rover_name',
        'rover_status',
        'img',
        'mission_report_id',
    ];

    public $incrementing = true;

    protected $primaryKey = 'id';

    public function missionReport()
    {
        return $this->belongsTo(MissionReport::class);
    }
}
