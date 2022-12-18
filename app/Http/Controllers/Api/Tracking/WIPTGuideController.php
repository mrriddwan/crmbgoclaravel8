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

        $travel_guides = $request->wip_travel_guide;
        $tracking_id = $request->tracking_tguide_id;

        $this->validate($request, [
            'wip_travel_guide.*.wip_package_name' => ['required', 'string'],
            'wip_travel_guide.*.wip_package_date' => ['required'],
            'tracking_tguide_id' => ['required', 'int'],
        ], [
            'wip_travel_guide.*.wip_package_name.required' => 'The name of the package is required',
            'wip_travel_guide.*.wip_package_date.required' => 'The package date is required',
            'tracking_tguide_id.required' => 'The tracking travel guide id is required',
        ]);

        foreach ($travel_guides as $tguide) {
            WipTravelGuide::create([
                'tracking_tguide_id' => $tracking_id,
                'wip_package_name' => $tguide['wip_package_name'],
                'wip_package_done' => 2,
                'wip_package_date' => $tguide['wip_package_date'] ? Carbon::parse($tguide['wip_package_date'])->toDate() : null,
                'wip_package_user_id' => $tguide['wip_package_user_id'] ? $tguide['wip_package_user_id ']: null,
                'wip_package_remark' => $tguide['wip_package_remark'] ? $tguide['wip_package_remark'] : null,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully store new package (wip) for travel guide',
        ]);
    }

    public function wip_tg_update(Request $request)
    {

        $travel_guides = $request->wip_travel_guide;
        $tracking_id = $request->tracking_tguide_id;

        $this->validate($request, [
            'wip_travel_guide.*.wip_package_name' => ['required', 'string'],
            'wip_travel_guide.*.wip_package_date' => ['required'],
            'tracking_tguide_id' => ['required', 'int'],
        ], [
            'wip_travel_guide.*.wip_package_name.required' => 'The name of the package is required',
            'wip_travel_guide.*.wip_package_date.required' => 'The package date is required',
            'tracking_tguide_id.required' => 'The tracking travel guide id is required',
        ]);

        foreach ($travel_guides as $tguide) {
            //if the id exists, update the data
            if(array_key_exists('id', $tguide)){
                WipTravelGuide::where('id',$tguide['id'])->update([
                    'wip_package_name' => $tguide['wip_package_name'],
                    'wip_package_done' => $tguide['wip_package_done'],
                    'wip_package_date' => $tguide['wip_package_date'] ? Carbon::parse($tguide['wip_package_date'])->toDate() : null,
                    'wip_package_user_id' => $tguide['wip_package_user_id'] ? $tguide['wip_package_user_id'] : null,
                    'wip_package_remark' => $tguide['wip_package_remark'] ? $tguide['wip_package_remark'] : null,
                ]);
            } else {
                //if the id does not exists, create the data
                WipTravelGuide::create([
                    'tracking_tguide_id' => $tracking_id,
                    'wip_package_name' => $tguide['wip_package_name'],
                    'wip_package_done' => $tguide['wip_package_done'],
                    'wip_package_date' => $tguide['wip_package_date'] ? Carbon::parse($tguide['wip_package_date'])->toDate() : null,
                    'wip_package_user_id' => $tguide['wip_package_user_id'] ? $tguide['wip_package_user_id ']: null,
                    'wip_package_remark' => $tguide['wip_package_remark'] ? $tguide['wip_package_remark'] : null,
                ]);
            }
        };

        return response()->json([
            'data' => $travel_guides,
            'status' => true,
            'message' => 'Successfully update package (wip) for travel guide',
        ]);
    }

    public function delete(WipTravelGuide $wip_travel_guide)
    {
        $wip_travel_guide->delete();
        return response()->json('wip_travel_guide deleted.');
    }
}
