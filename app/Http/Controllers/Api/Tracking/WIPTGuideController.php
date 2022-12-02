<?php

namespace App\Http\Controllers\Api\Tracking;

use App\Http\Controllers\Controller;
use App\Models\Tracking\WipTravelGuide;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WIPTGuideController extends Controller
{
    public function wip_tg_store(Request $request)
    {

        $request->validate([

            'tracking_tguide_id' => ['required', 'int'],
            'wip_package_name' => ['required', 'string'],
            'wip_package_date' => ['required'],
            // 'wip_package_user_id' => ['required', 'int'],
            // 'wip_package_remark' => ['required', 'string'],
        ], [
            'tracking_tguide_id.required' => 'The tracking travel guide id is required',
            'wip_package_name.required' => 'The name of the package is required',
            'wip_package_date.required' => 'The package date is required',
            // 'wip_package_user_id.required' => 'The size is required.',
            // 'wip_package_remark.required' => 'The travel guide tracking remark is required',
        ]);


        $wip_travel_guide = WipTravelGuide::create([
            'tracking_tguide_id' => $request->tracking_tguide_id,
            'wip_package_name' => $request->wip_package_name,
            'wip_package_done' => $request->wip_package_done,
            'wip_package_date' => $request->wip_package_date ? Carbon::parse($request->wip_package_date)->toDate() : null,
            'wip_package_user_id' => $request->wip_package_user_id ? $request->wip_package_user_id : null,
            'wip_package_remark' => $request->wip_package_remark ? $request->wip_package_remark : null,
        ]);

        return response()->json([
            'data' => $wip_travel_guide,
            'status' => true,
            'message' => 'Successfully store new package (wip) for travel guide',
        ]);
    }

    public function wip_tg_update(Request $request, WipTravelGuide $wip_travel_guide)
    {

        $request->validate([

            // 'tracking_tguide_id' => ['required', 'int'],
            'wip_package_name' => ['required', 'string'],
            'wip_package_date' => ['required'],
            // 'wip_package_user_id' => ['required', 'int'],
            // 'wip_package_remark' => ['required', 'string'],
        ], [
            // 'tracking_tguide_id.required' => 'The tracking travel guide id is required',
            'wip_package_name.required' => 'The name of the package is required',
            'wip_package_date.required' => 'The package date is required',
            // 'wip_package_user_id.required' => 'The size is required.',
            // 'wip_package_remark.required' => 'The travel guide tracking remark is required',
        ]);


        $wip_travel_guide->update([
            // 'tracking_tguide_id' => $request->tracking_tguide_id,
            'wip_package_name' => $request->wip_package_name,
            'wip_package_done' => $request->wip_package_done,
            'wip_package_date' => $request->wip_package_date ? Carbon::parse($request->wip_package_date)->toDate() : null,
            'wip_package_user_id' => $request->wip_package_user_id ? $request->wip_package_user_id : null,
            'wip_package_remark' => $request->wip_package_remark ? $request->wip_package_remark : null,
        ]);

        return response()->json([
            'data' => $wip_travel_guide,
            'status' => true,
            'message' => 'Successfully update package (wip) for travel guide',
        ]);
    }
}
