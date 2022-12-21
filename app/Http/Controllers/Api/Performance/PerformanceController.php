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

        // foreach ($travel_guides as $tguide) {
        //     //if the id exists, update the data
        //     if(array_key_exists('id', $tguide)){
        //         WipTravelGuide::where('id',$tguide['id'])->update([
        //             'wip_package_name' => $tguide['wip_package_name'],
        //             'wip_package_done' => $tguide['wip_package_done'],
        //             'wip_package_date' => $tguide['wip_package_date'] ? Carbon::parse($tguide['wip_package_date'])->toDate() : null,
        //             'wip_package_user_id' => $tguide['wip_package_user_id'] ? $tguide['wip_package_user_id'] : null,
        //             'wip_package_remark' => $tguide['wip_package_remark'] ? $tguide['wip_package_remark'] : null,
        //         ]);
        //     } else {
        //         //if the id does not exists, create the data
        //         WipTravelGuide::create([
        //             'tracking_tguide_id' => $tracking_id,
        //             'wip_package_name' => $tguide['wip_package_name'],
        //             'wip_package_done' => $tguide['wip_package_done'],
        //             'wip_package_date' => $tguide['wip_package_date'] ? Carbon::parse($tguide['wip_package_date'])->toDate() : null,
        //             'wip_package_user_id' => $tguide['wip_package_user_id'] ? $tguide['wip_package_user_id ']: null,
        //             'wip_package_remark' => $tguide['wip_package_remark'] ? $tguide['wip_package_remark'] : null,
        //         ]);
        //     }
        // };

        // return response()->json([
        //     'data' => $travel_guides,
        //     'status' => true,
        //     'message' => 'Successfully update package (wip) for travel guide',
        // ]);
    }
}
