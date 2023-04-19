<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionImage extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $primaryKey = 'id';

    public function report() {
        return $this->belongsTo(MissionReport::class);
    }
}
