<?php

namespace App\Models\Performance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceTarget extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'action_id',
        'action_target',
        'target_remark',
    ];
}
