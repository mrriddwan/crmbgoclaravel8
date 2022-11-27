<?php

namespace App\Http\Controllers\Api\Tracking;

use App\Http\Controllers\Controller;
use App\Models\Tracking\TrackingGeneral;
use App\Models\Tracking\WipGeneral;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WIPGeneralController extends Controller
{
    public function show($id)
    {
        // $wip_general = WipGeneral::find($id);
        // return response()->json(['data' => $wip_general]);
        $wip_general = WipGeneral::with([
            'tracking_general' => function ($q) {
                $q->select([
                    'tracking_generals.id',
                    'tracking_generals.company_id',
                    'tracking_generals.user_id',
                    'tracking_generals.contact_category_id',
                    'tracking_generals.category_description',
                    'tracking_generals.general_amount',
                    'tracking_generals.art_frequency',
                    'tracking_generals.general_type',
                    'tracking_generals.general_startdate',
                    'tracking_generals.general_enddate',
                    'tracking_generals.progress',
                    'tracking_generals.general_remark',
                ]);
            },
            'art_chase_user' => function ($q) {
                $q->select([
                    'id',
                    'name',
                ]);
            },
            'art_received_user' => function ($q) {
                $q->select([
                    'id',
                    'name',
                ]);
            },
            'art_todo_user' => function ($q) {
                $q->select([
                    'id',
                    'name',
                ]);
            },
            'cns_sent_user' => function ($q) {
                $q->select([
                    'id',
                    'name',
                ]);
            },
            'cns_record_user' => function ($q) {
                $q->select([
                    'id',
                    'name',
                ]);
            },
            'schedule_user' => function ($q) {
                $q->select([
                    'id',
                    'name',
                ]);
            },
            'actual_live_user' => function ($q) {
                $q->select([
                    'id',
                    'name',
                ]);
            },
            'client_posting_user' => function ($q) {
                $q->select([
                    'id',
                    'name',
                ]);
            },
            'report_user' => function ($q) {
                $q->select([
                    'id',
                    'name',
                ]);
            },
        ])
            // ->select([
            //     'wip_generals.*',
            // ])
            ->join('tracking_generals', 'wip_generals.tracking_general_id', '=', 'tracking_generals.id')
            ->where('wip_generals.id', '=', $id)
            // ->find($id)
            ->get()
            ;

            return response()->json(['data' => $wip_general]);
    }

    public function update(WipGeneral $wip_general, Request $request)
    {

        $request->validate([
            'general_startdate' => ['required'],
            'general_enddate' => ['required', 'after:general_startdate'],
            'user_id' => ['required', 'int'],
            'company_id' => ['required', 'int'],
            'contact_category_id' => ['required', 'int'],
        ], [
            'general_startdate.required' => 'The start date is required',
            'general_enddate.required' => 'The end task is required.',
            'user_id.required' => 'Please select a user',
            'company_id.required' => 'Please select a company',
            'contact_category_id.required' => 'Please select a category',
        ]);


        $general = TrackingGeneral::where('id','=', $request->tracking_general_id)->update([
            'general_startdate' => Carbon::parse($request->general_startdate)->toDate(),
            'general_enddate' => Carbon::parse($request->general_enddate)->toDate(),
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
            'contact_category_id' => $request->contact_category_id,
        ]);

        $wip_general->update([
            'wip_remark' => $request->wip_remark ? $request->wip_remark : 'No remark',
            'wip_progress' => $request->wip_progress ? $request->wip_progress : 'Pending',
            'art_chase_date' => $request->art_chase_date ? Carbon::parse($request->art_chase_date)->toDate() : null,
            'art_chase_done'=> $request->art_chase_done,
            'art_chase_user_id' => $request->art_chase_user_id ? $request->art_chase_user_id : null,
            'art_chase_remark' => $request->art_chase_remark ? $request->art_chase_remark : null,

            'art_received_date' => $request->art_received_date ? Carbon::parse($request->art_received_date)->toDate() : null,
            'art_received_done'=> $request->art_received_done,
            'art_received_user_id' => $request->art_received_user_id ? $request->art_received_user_id : null,
            'art_received_remark' => $request->art_received_remark ? $request->art_received_remark : null,

            'art_todo_date' => $request->art_todo_date ? Carbon::parse($request->art_todo_date)->toDate() : null,
            'art_todo_done'=> $request->art_todo_done,
            'art_todo_user_id' => $request->art_todo_user_id ? $request->art_todo_user_id : null,
            'art_todo_remark' => $request->art_todo_remark ? $request->art_todo_remark : null,

            'cns_sent_date' => $request->cns_sent_date ? Carbon::parse($request->cns_sent_date)->toDate() : null,
            'cns_sent_done'=> $request->cns_sent_done,
            'cns_sent_user_id' => $request->cns_sent_user_id ? $request->cns_sent_user_id : null,
            'cns_sent_remark' => $request->cns_sent_remark ? $request->cns_sent_remark : null,

            'cns_record_date' => $request->cns_record_date ? Carbon::parse($request->cns_record_date)->toDate() : null,
            'cns_record_done'=> $request->cns_record_done,
            'cns_record_user_id' => $request->cns_record_user_id ? $request->cns_record_user_id : null,
            'cns_record_remark' => $request->cns_record_remark ? $request->cns_record_remark : null,

            'schedule_date' => $request->schedule_date ? Carbon::parse($request->schedule_date)->toDate() : null,
            'schedule_done'=> $request->schedule_done,
            'schedule_user_id' => $request->schedule_user_id ? $request->schedule_user_id : null,
            'schedule_remark' => $request->schedule_remark ? $request->schedule_remark : null,

            'actual_live_date' => $request->actual_live_date ? Carbon::parse($request->actual_live_date)->toDate() : null,
            'actual_live_done'=> $request->actual_live_done,
            'actual_live_remark' => $request->actual_live_remark ? $request->actual_live_remark : null,
            'actual_live_user_id' => $request->actual_live_user_id ? $request->actual_live_user_id : null,

            'client_posting_date' => $request->client_posting_date ? Carbon::parse($request->client_posting_date)->toDate() : null,
            'client_posting_done'=> $request->client_posting_done,
            'client_posting_user_id' => $request->client_posting_user_id ? $request->client_posting_user_id : null,
            'client_posting_remark' => $request->client_posting_remark ? $request->client_posting_remark : null,

            'report_date' => $request->report_date ? Carbon::parse($request->report_date)->toDate() : null,
            'report_done'=> $request->report_done,
            'report_remark' => $request->report_remark ? $request->report_remark : null,
            'report_user_id' => $request->report_user_id ? $request->report_user_id : null,
        ]);

        
        return response()->json([
            'data' => $general,
            'status' => true,
            'message' => 'Successfully update wip tracking general',
        ]);
    }

    public function delete(WipGeneral $wip_general)
    {
        $wip_general->delete();
        return response()->json('wip_general deleted.');
    }
}
