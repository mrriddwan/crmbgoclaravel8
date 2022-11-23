<?php

namespace App\Http\Controllers\Api\Tracking;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tracking\TrackingGeneralResource;
use App\Http\Resources\Tracking\WIPGeneralResource;
use App\Models\Admin\SvSbPivot;
use App\Models\Tracking\TrackingGeneral;
use App\Models\Tracking\WipGeneral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrackingGeneralController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedUser = request('selectedUser');
        $selectedCategory = request('selectedtCategory');
        $view_type = request('view_type');


        $id = Auth::id();

        // if (
        //     (DB::table('model_has_roles')
        //         ->where('model_id', '=', $id)
        //         ->where('role_id', '=', 2)
        //         ->exists()) ||
        //     (DB::table('model_has_roles')
        //         ->where('model_id', '=', $id)
        //         ->where('role_id', '=', 1)
        //         ->exists())
        // ) {
        if ($view_type === 'master') {
            $general = TrackingGeneral::select([
                'tracking_generals.*',
                'contact_categories.name as category_name',
                'users.name as user_name',
                'contacts.name as company_name',
            ])
                ->join('contacts', 'tracking_generals.company_id', '=', 'contacts.id')
                ->join('contact_categories', 'tracking_generals.contact_category_id', '=', 'contact_categories.id')
                ->join('users', 'tracking_generals.user_id', '=', 'users.id')
                ->when($selectedCategory, function ($query) use ($selectedCategory) {
                    $query->where('tracking_generals.contact_category_id', $selectedCategory);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('tracking_generals.user_id', $selectedUser);
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);
            // ->get();

            return TrackingGeneralResource::collection($general);
        } else {
            $wip = WipGeneral::with([
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
                ->select([
                    'wip_generals.*',
                ])
                ->join('tracking_generals', 'wip_generals.tracking_general_id', '=', 'tracking_generals.id')
                // ->when($selectedCategory, function ($query) use ($selectedCategory) {
                //     $query->where('tracking_generals.contact_category_id', $selectedCategory);
                // })
                // ->when($selectedUser, function ($query) use ($selectedUser) {
                //     $query->where('tracking_generals.user_id', $selectedUser);
                // })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);
            // ->get();

            return WIPGeneralResource::collection($wip);
        }

        // } else {
        //     $sv_sb = "";
        //     $final = [$id];

        //     if (SvSbPivot::where('supervisor_id', '=', $id)->exists()) {
        //         $sv_sb = SvSbPivot::select('subordinate_id')
        //             ->where('supervisor_id', '=', $id)
        //             ->pluck('subordinate_id');
        //     } else {
        //         $sv_sb = ["null"];
        //     }
        //     array_push($final, ...$sv_sb);

        //     $tracking = TrackingGeneral::select([
        //         'to_dos.*',
        //         'contact_statuses.name as status_name',
        //         'contact_types.name as type_name',
        //         'users.name as user_name',
        //         'tasks.name as task_name',
        //         'priorities.name as priority_name',
        //         'text_colors.color_code as color_name',
        //         'contacts.name as contact_name',
        //         'to_do_sources.name as source_name',
        //         'actions.name as action_name',
        //     ])
        //         ->whereIn('to_dos.user_id', $final) // for view under supervisor and the subordinates
        //         ->join('contacts', 'to_dos.contact_id', '=', 'contacts.id')
        //         ->join('contact_statuses', 'to_dos.status_id', '=', 'contact_statuses.id')
        //         ->join('contact_types', 'to_dos.type_id', '=', 'contact_types.id')
        //         ->join('tasks', 'to_dos.task_id', '=', 'tasks.id')
        //         ->join('priorities', 'to_dos.priority_id', '=', 'priorities.id')
        //         ->join('users', 'to_dos.user_id', '=', 'users.id')
        //         ->join('text_colors', 'to_dos.color_id', '=', 'text_colors.id')
        //         ->leftJoin('to_do_sources', 'to_dos.source_id', '=', 'to_do_sources.id')
        //         ->leftJoin('actions', 'to_dos.action_id', '=', 'actions.id')
        //         ->when($selectedCategory, function ($query) use ($selectedCategory) {
        //             $query->where('to_dos.status_id', $selectedCategory);
        //         })
        //         ->when($selectedUser, function ($query) use ($selectedUser) {
        //             $query->where('to_dos.user_id', $selectedUser);
        //         })
        //         ->orderBy($sort_field, $sort_direction)
        //         ->search(trim($search_term))
        //         ->paginate($paginate);

        //     return TrackingGeneralResource::collection($tracking);
        // }
    }

    public function store(Request $request)
    {

        $request->validate([
            'general_startdate' => ['required'],
            'general_enddate' => ['required', 'after:general_startdate'],
            'user_id' => ['required', 'int'],
            'company_id' => ['required', 'int'],
            'contact_category_id' => ['required', 'int'],
            'category_description' => ['required', 'string'],
            'art_frequency' => ['required', 'int'],
            'general_amount' => ['required', 'int'],
            'general_type' => ['required', 'string'],
            'general_reach' => ['required', 'int',],
            'general_tenure' => ['required', 'int'],
            'art_format' => ['required', 'string'],
            'general_remark' => ['required', 'string'],
        ], [
            'general_startdate.required' => 'The start date is required',
            'general_enddate.required' => 'The end task is required.',
            'general_enddate.after' => 'The end date must be after the start date.',
            'user_id.required' => 'Please select a user',
            'company_id.required' => 'Please select a company',
            'contact_category_id.required' => 'Please select a category',
            'category_description.required' => 'The category description is required.',
            'art_frequency.required' => 'The art frequency is required',
            'general_amount.required' => 'The amount is required.',
            'general_type.required' => 'The job type is required.',
            'general_reach.required' => 'The reach is required',
            'general_tenure.required' => 'The tenure is required.',
            'art_format.required' => 'The art format is required',
            'general_remark.required' => 'The remark is required.',
        ]);


        $general = TrackingGeneral::create([
            'progress' => 'Pending',
            'general_startdate' => Carbon::parse($request->general_startdate)->toDate(),
            'general_enddate' => Carbon::parse($request->general_enddate)->toDate(),
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
            'contact_category_id' => $request->contact_category_id,
            'category_description' => $request->category_description,
            'art_frequency' => $request->art_frequency,
            'general_amount' => $request->general_amount,
            'general_type' => $request->general_type,
            'general_reach' => $request->general_reach,
            'general_tenure' => $request->general_tenure,
            'art_format' => $request->art_format,
            'general_remark' => $request->general_remark,
        ]);

        for ($x = 1; $x <= $request->art_frequency; $x++) {
            $wip = WipGeneral::create([
                'tracking_general_id' => $general->id,
                'frequency_no' => $x,
            ]);
        }

        
        return response()->json([
            'data' => [$general, $wip],
            'status' => true,
            'message' => 'Successfully store new tracking and create new WIP',
        ]);
    }

    public function show($id)
    {
        $general = TrackingGeneral::find($id);
        return response()->json(['data' => $general]);
    }

    public function update(TrackingGeneral $general, Request $request)
    {

        $request->validate([
            'general_startdate' => ['required'],
            'general_enddate' => ['required', 'after:general_startdate'],
            'user_id' => ['required', 'int'],
            'company_id' => ['required', 'int'],
            'contact_category_id' => ['required', 'int'],
            'category_description' => ['required', 'string'],
            'art_frequency' => ['required', 'int'],
            'general_amount' => ['required', 'int'],
            'general_type' => ['required', 'string'],
            'general_reach' => ['required', 'int',],
            'general_tenure' => ['required', 'int'],
            'art_format' => ['required', 'string'],
            'general_remark' => ['required', 'string'],
        ], [
            'general_startdate.required' => 'The start date is required',
            'general_enddate.required' => 'The end task is required.',
            'user_id.required' => 'Please select a user',
            'company_id.required' => 'Please select a company',
            'contact_category_id.required' => 'Please select a category',
            'category_description.required' => 'The category description is required.',
            'art_frequency.required' => 'The art frequency is required',
            'general_amount.required' => 'The amount is required.',
            'general_type.required' => 'The job type is required.',
            'general_reach.required' => 'The reach is required',
            'general_tenure.required' => 'The tenure is required.',
            'art_format.required' => 'The art format is required',
            'general_remark.required' => 'The remark is required.',
        ]);


        $general->update([
            'progress' => 'Pending',
            'general_startdate' => Carbon::parse($request->general_startdate)->toDate(),
            'general_enddate' => Carbon::parse($request->general_enddate)->toDate(),
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
            'contact_category_id' => $request->contact_category_id,
            'category_description' => $request->category_description,
            'art_frequency' => $request->art_frequency,
            'general_amount' => $request->general_amount,
            'general_type' => $request->general_type,
            'general_reach' => $request->general_reach,
            'general_tenure' => $request->general_tenure,
            'art_format' => $request->art_format,
            'general_remark' => $request->general_remark,
        ]);

        
        return response()->json([
            'data' => $general,
            'status' => true,
            'message' => 'Successfully update master tracking general',
        ]);
    }
}