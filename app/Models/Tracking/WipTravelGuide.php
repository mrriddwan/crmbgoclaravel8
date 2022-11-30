<?php

namespace App\Models\Tracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipTravelGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_tguide_id',
        'wip_package_date',
        'wip_package_done',
        'wip_package_user_id',
        'wip_package_remark',
    ];
}
