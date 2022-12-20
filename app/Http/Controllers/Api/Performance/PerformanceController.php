<?php

namespace App\Http\Controllers\Api\Performance;

use App\Http\Controllers\Controller;
use App\Models\Performance\PerformanceTarget;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function target($user_id)
    {
        $target = PerformanceTarget::join('users','performance_targets.user_id', '=', 'users.id')
            ->join('actions', 'performance_targets.action_id', '=','actions.id')
            ->select(
            'performance_targets.id',
            'performance_targets.user_id',
            'performance_targets.action_target',
            'performance_targets.target_remark',
            'performance_targets.action_id',
            'users.name as user_name',
            'actions.name as action_name',
            )
            ->where('performance_targets.user_id', $user_id)
            ->orderBy('action_name')
            ->get()
            
            ;

        return response()->json([
            'data' => $target,
            'message' => 'Performance target for the user obtained',
        ]);
    }
}
