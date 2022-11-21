<?php

namespace App\Models\Tracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingGeneral extends Model
{
    use HasFactory;

    protected $fillable = [
        'progress',
        'track_startdate',
        'track_enddate',
        'user_id',
        'company_id',
        'contact_category_id',
        'category_description',
        'art_frequency',
        'job_type',
        'reach',
        'tenure',
        'art_format',
        'tracking_remark'
    ];
}
