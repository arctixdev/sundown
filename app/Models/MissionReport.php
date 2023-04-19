<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionReport extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $primaryKey = 'id';

    public function images() {
        return $this->hasMany(MissionImage::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
