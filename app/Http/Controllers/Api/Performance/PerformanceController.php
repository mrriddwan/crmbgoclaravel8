<?php

namespace App\Http\Controllers\Api\Performance;

use App\Http\Controllers\Controller;
use App\Models\Performance\PerformanceTarget;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function target($user_id)
    {
        $target = PerformanceTarget::join('users', 'performance_targets.user_id', '=', 'users.id')
            ->join('actions', 'performance_targets.action_id', '=', 'actions.id')
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
            ->get();

        return response()->json([
            'data' => $target,
            'message' => 'Performance target for the user obtained',
        ]);
    }

    public function target_update(Request $request)
    {

        // dd($request);

        $action_target = $request->action_target;
        $actions = $request->actions;
        $user_id = $request->user_id;

        //loop through the actions
        for ($index = 0; $index < count($actions); $index++) {
            //if user_id && action_id combo from database performance target exists
            if (PerformanceTarget::where('user_id', $user_id)->where('action_id', $actions[$index]['id'])->exists()) {
                //update the current data
                PerformanceTarget::where('user_id', $user_id)->where('action_id', $actions[$index]['id'])->update([
                    'action_target' => $action_target[$index] ?? 0,
                ]);
            } else {
                //else, create a new data
                PerformanceTarget::create([
                    'user_id' => $user_id,
                    'action_id' => $actions[$index]['id'],
                    'action_target' => $action_target[$index] ?? 0,
                    // 'target_remark' $action_target[$index] ?? 0,
                ]);
            }
        }

        return response()->json([
                'status' => true,
                'message' => 'Successfully update user performance target',
            ]);
    }
}
