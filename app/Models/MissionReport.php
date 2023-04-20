<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'lat',
        'lon',
        'finalisation_date',
        'created_at',
        'mission_date',
        'user_id',
    ];

    public $incrementing = true;

    protected $primaryKey = 'id';

    public function images()
    {
        return $this->hasMany(MissionImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
