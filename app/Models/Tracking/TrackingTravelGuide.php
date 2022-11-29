<?php

namespace App\Models\Tracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingTravelGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'edition',
        'tguide_size',
        'tguide_remark',
    ];
}
