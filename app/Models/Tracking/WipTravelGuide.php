<?php

namespace App\Models\Tracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipTravelGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_tguide_id',
        'wip_assignment_date',
        'wip_assignment_done',
        'wip_assignment_user_id',
        'wip_assignment_remark',
    ];
}
