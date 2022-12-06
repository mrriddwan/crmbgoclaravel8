<?php

namespace App\Models\Tracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BluedaleDivision extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function tracking_general(){
        return $this->belongsTo(TrackingGeneral::class);
    }
}
