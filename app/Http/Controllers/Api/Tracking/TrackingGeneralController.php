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
        $selectedCategory = request('selectedCategory');
        $selectedResult = request('selectedResult');
        $view_type = request('view_type');


        $id = Auth::id();

        if (
            (DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 2)
                ->exists()) ||
            (DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 1)
                ->exists())
        ) {
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
                ->when($selectedResult, function ($query) use ($selectedResult) {
                    $query->where('tracking_generals.progress', $selectedResult);
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);
            // ->get();

            return TrackingGeneralResource::collection($general);
        } else {
            $wip_general = WipGeneral::with([
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
                    'contacts.name as company_name',
                    'users.name as user_name',
                    'contact_categories.name as category_name',
                    'tracking_generals.id as general_id',
                    'tracking_generals.company_id',
                    'tracking_generals.user_id',
                    'tracking_generals.contact_category_id',
                    'tracking_generals.category_description as general_category_description',
                    'tracking_generals.general_amount as general_amount',
                    'tracking_generals.art_frequency as general_art_freq',
                    'tracking_generals.general_type as general_type',
                    'tracking_generals.general_startdate as general_startdate',
                    'tracking_generals.general_enddate as general_enddate',
                    'tracking_generals.progress as general_progress',
                    'tracking_generals.general_remark as general_remark',
                    
                ])
                ->join('tracking_generals', 'wip_generals.tracking_general_id', '=', 'tracking_generals.id')
                ->join('contacts', 'tracking_generals.company_id', '=', 'contacts.id')
                ->join('users', 'tracking_generals.user_id', '=', 'users.id')
                ->join('contact_categories', 'tracking_generals.contact_category_id', '=', 'contact_categories.id')
                ->when($selectedCategory, function ($query) use ($selectedCategory) {
                    $query->where('tracking_generals.contact_category_id', $selectedCategory);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('tracking_generals.user_id', $selectedUser);
                })
                ->when($selectedResult, function ($query) use ($selectedResult) {
                    $query->where('wip_generals.wip_progress', $selectedResult);
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);

            return WIPGeneralResource::collection($wip_general);
        }

        } else {
            $sv_sb = "";
            $final = [$id];

            if (SvSbPivot::where('supervisor_id', '=', $id)->exists()) {
                $sv_sb = SvSbPivot::select('subordinate_id')
                    ->where('supervisor_id', '=', $id)
                    ->pluck('subordinate_id');
            } else {
                $sv_sb = ["null"];
            }
            array_push($final, ...$sv_sb);
            // ->whereIn('to_dos.user_id', $final) // for view under supervisor and the subordinates

            if ($view_type === 'master') {
                $general = TrackingGeneral::select([
                    'tracking_generals.*',
                    'contact_categories.name as category_name',
                    'users.name as user_name',
                    'contacts.name as company_name',
                ])
                    ->whereIn('tracking_generals.user_id', $final) 
                    ->join('contacts', 'tracking_generals.company_id', '=', 'contacts.id')
                    ->join('contact_categories', 'tracking_generals.contact_category_id', '=', 'contact_categories.id')
                    ->join('users', 'tracking_generals.user_id', '=', 'users.id')
                    ->when($selectedCategory, function ($query) use ($selectedCategory) {
                        $query->where('tracking_generals.contact_category_id', $selectedCategory);
                    })
                    ->when($selectedUser, function ($query) use ($selectedUser) {
                        $query->where('tracking_generals.user_id', $selectedUser);
                    })
                    ->when($selectedResult, function ($query) use ($selectedResult) {
                        $query->where('tracking_generals.progress', $selectedResult);
                    })
                    ->orderBy($sort_field, $sort_direction)
                    ->search(trim($search_term))
                    ->paginate($paginate);
    
                return TrackingGeneralResource::collection($general);
            } else {
                $wip_general = WipGeneral::with([
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
                        'contacts.name as company_name',
                        'users.name as user_name',
                        'contact_categories.name as category_name',
                        'tracking_generals.id as general_id',
                        'tracking_generals.company_id',
                        'tracking_generals.user_id',
                        'tracking_generals.contact_category_id',
                        'tracking_generals.category_description as general_category_description',
                        'tracking_generals.general_amount as general_amount',
                        'tracking_generals.art_frequency as general_art_freq',
                        'tracking_generals.general_type as general_type',
                        'tracking_generals.general_startdate as general_startdate',
                        'tracking_generals.general_enddate as general_enddate',
                        'tracking_generals.progress as general_progress',
                        'tracking_generals.general_remark as general_remark',
                        
                    ])
                    ->whereIn('tracking_generals.user_id', $final) 
                    ->join('tracking_generals', 'wip_generals.tracking_general_id', '=', 'tracking_generals.id')
                    ->join('contacts', 'tracking_generals.company_id', '=', 'contacts.id')
                    ->join('users', 'tracking_generals.user_id', '=', 'users.id')
                    ->join('contact_categories', 'tracking_generals.contact_category_id', '=', 'contact_categories.id')
                    ->when($selectedCategory, function ($query) use ($selectedCategory) {
                        $query->where('tracking_generals.contact_category_id', $selectedCategory);
                    })
                    ->when($selectedUser, function ($query) use ($selectedUser) {
                        $query->where('tracking_generals.user_id', $selectedUser);
                    })
                    ->when($selectedResult, function ($query) use ($selectedResult) {
                        $query->where('wip_generals.wip_progress', $selectedResult);
                    })
                    ->orderBy($sort_field, $sort_direction)
                    ->search(trim($search_term))
                    ->paginate($paginate);
    
                return WIPGeneralResource::collection($wip_general);
            }
        }
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
                'wip_progress' => 'Pending',
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
            'progress' => $request->progress,
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

    public function delete(TrackingGeneral $tracking_general)
    {
        $tracking_general->delete();
        return response()->json('tracking_general deleted.');
    }

}
