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

    public function update(Request $request, WipTravelGuide $wip_travel_guide)
    {

        $request->validate([

            'user_id' => ['required', 'int'],
            'company_id' => ['required', 'int'],
            'edition' => ['required', 'string'],
            'tguide_size' => ['required', 'string'],
            'tguide_remark' => ['required', 'string'],
            // 'art_reminder_date' => ['required'],
            // 'art_reminder_remark' => ['required', 'string'],
            // 'art_reminder_user_id' => ['required', 'int'],
            // 'art_record_date' => ['required'],
            // 'art_record_remark' => ['required', 'string',],
            // 'art_record_user_id' => ['required', 'int'],
        ], [
   
   
            'user_id.required' => 'Please select a user',
            'company_id.required' => 'Please select a company',
            'edition.required' => 'The edition is required',
            'tguide_size.required' => 'The size is required.',
            'tguide_remark.required' => 'The travel guide tracking remark is required',
            // 'general_startdate.required' => 'The start date is required',
            // 'general_enddate.required' => 'The end task is required.',
            // 'general_amount.required' => 'The amount is required.',
            // 'general_type.required' => 'The job type is required.',
            // 'general_reach.required' => 'The reach is required',
            // 'general_tenure.required' => 'The tenure is required.',
            // 'art_format.required' => 'The art format is required',
            // 'general_remark.required' => 'The remark is required.',
        ]);


        $wip_travel_guide->update([
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
            'edition' => $request->edition,
            'tguide_size' => $request->tguide_size,
            'tguide_remark' => $request->tguide_remark,
            'art_reminder_date' => $request->art_reminder_date ? Carbon::parse($request->art_reminder_date)->toDate() : null,
            'art_reminder_remark' => $request->art_reminder_remark ? $request->art_reminder_remark : null,
            'art_reminder_done' => $request->art_reminder_done,
            'art_reminder_user_id' => $request->art_reminder_user_id ? $request->art_reminder_user_id : null,
            'art_record_date' => $request->art_record_date ? Carbon::parse($request->art_record_date)->toDate() : null,
            'art_record_remark' => $request->art_record_remark ? $request->art_record_remark : null,
            'art_record_done' => $request->art_record_done,
            'art_record_user_id' => $request->art_record_user_id ? $request->art_record_user_id : null,
        ]);

        return response()->json([
            'data' => $wip_travel_guide,
            'status' => true,
            'message' => 'Successfully update package(wip) for travel guide',
        ]);
    }
}
