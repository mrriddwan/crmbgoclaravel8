<?php

namespace App\Http\Controllers\Api\Tracking;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tracking\TrackingTGuideResource;
use App\Models\Tracking\TrackingTravelGuide;
use App\Models\Tracking\WipTravelGuide;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrackingTGuideController extends Controller
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



        if ($view_type === 'master') {
            $travel_guide = TrackingTravelGuide::select([
                'tracking_travel_guides.*',
                'users.name as user_name',
                'contacts.name as company_name',
            ])
                ->join('contacts', 'tracking_travel_guides.company_id', '=', 'contacts.id')
                ->join('users', 'tracking_travel_guides.user_id', '=', 'users.id')
                ->with([
                    'wip_travel_guide' => function ($q) {
                        $q->select(
                            [
                                'wip_travel_guides.id',
                                'tracking_tguide_id',
                                'wip_package_name',
                                'wip_package_date',
                                'wip_package_done',
                                'wip_package_user_id',
                                'users.name as package_user_name',
                            ]
                        )
                        ->leftJoin('users', 'wip_travel_guides.wip_package_user_id', '=', 'users.id')
                        ;
                    },
                ])
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('tracking_travel_guides.user_id', $selectedUser);
                })
                // ->when($selectedResult, function ($query) use ($selectedResult) {
                //     $query->where('tracking_generals.progress', $selectedResult);
                // })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);
            // ->get();

            return TrackingTGuideResource::collection($travel_guide);
        } else {
            if ($view_type === 'wip') {
                $travel_guide = TrackingTravelGuide::select([
                    'tracking_travel_guides.*',
                    'users.name as user_name',
                    'contacts.name as company_name',
                ])
                    ->join('contacts', 'tracking_travel_guides.company_id', '=', 'contacts.id')
                    ->join('users', 'tracking_travel_guides.user_id', '=', 'users.id')
                    ->with([
                        'art_reminder_user' => function ($q) {
                            $q->select([
                                'id',
                                'name',
                            ]);
                        },
                        'art_record_user' => function ($q) {
                            $q->select([
                                'id',
                                'name',
                            ]);
                        },
                        'wip_travel_guide' => function ($q) {
                            $q->select(
                                [
                                    'wip_travel_guides.id',
                                    'tracking_tguide_id',
                                    'wip_package_name',
                                    'wip_package_date',
                                    'wip_package_done',
                                    'wip_package_user_id',
                                    'wip_package_remark',
                                    'users.name as package_user_name',
                                ]
                            )
                            ->leftJoin('users', 'wip_travel_guides.wip_package_user_id', '=', 'users.id')
                            ;
                        },
                    ])
                    ->when($selectedUser, function ($query) use ($selectedUser) {
                        $query->where('tracking_travel_guides.user_id', $selectedUser);
                    })
                    ->orderBy($sort_field, $sort_direction)
                    ->search(trim($search_term))
                    ->paginate($paginate);
                // ->get();

                return TrackingTGuideResource::collection($travel_guide);
                // return $travel_guide;
            }
        }
    }

    public function show($id)
    {
        $travel_guide = TrackingTravelGuide::select([
            'tracking_travel_guides.*',
            'users.name as user_name',
            'contacts.name as company_name',
        ])
            ->join('contacts', 'tracking_travel_guides.company_id', '=', 'contacts.id')
            ->join('users', 'tracking_travel_guides.user_id', '=', 'users.id')
            ->with([
                'art_reminder_user' => function ($q) {
                    $q->select([
                        'id',
                        'name',
                    ]);
                },
                'art_record_user' => function ($q) {
                    $q->select([
                        'id',
                        'name',
                    ]);
                },
                'wip_travel_guide' => function ($q) {
                    $q->select(
                        [
                            'wip_travel_guides.id',
                            'tracking_tguide_id',
                            'wip_package_name',
                            'wip_package_date',
                            'wip_package_done',
                            'wip_package_user_id',
                            'wip_package_remark',
                            'users.name as package_user_name',
                        ]
                    )
                    ->leftJoin('users', 'wip_travel_guides.wip_package_user_id', '=', 'users.id')
                    ->orderBy('wip_package_date');
                },
            ])
            ->where('tracking_travel_guides.id', '=', $id)
            ->get();

        return TrackingTGuideResource::collection($travel_guide);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'int'],
            'company_id' => ['required', 'int'],
            'edition' => ['required', 'string'],
            'tguide_size' => ['required', 'string'],
            // 'tguide_remark' => ['required', 'string'],
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
            // 'tguide_remark.required' => 'The travel guide tracking remark is required',
            // 'general_startdate.required' => 'The start date is required',
            // 'general_enddate.required' => 'The end task is required.',
            // 'general_amount.required' => 'The amount is required.',
            // 'general_type.required' => 'The job type is required.',
            // 'general_reach.required' => 'The reach is required',
            // 'general_tenure.required' => 'The tenure is required.',
            // 'art_format.required' => 'The art format is required',
            // 'general_remark.required' => 'The remark is required.',
        ]);


        $travel_guide = TrackingTravelGuide::create([
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
            'edition' => $request->edition,
            'tguide_size' => $request->tguide_size,
            'tguide_remark' => $request->tguide_remark,
            'art_reminder_date' => $request->art_reminder_date ? Carbon::parse($request->art_reminder_date)->toDate() : null,
            'art_reminder_remark' => $request->art_reminder_remark ? $request->art_reminder_remark : 'No remark',
            'art_reminder_done' => 2,
            'art_reminder_user_id' => $request->art_reminder_user_id ? $request->art_reminder_user_id : null,
            'art_record_date' => $request->art_record_date ? Carbon::parse($request->art_record_date)->toDate() : null,
            'art_record_remark' => $request->art_record_remark ? $request->art_record_remark : 'No remark',
            'art_record_done' => 2,
            'art_record_user_id' => $request->art_record_user_id ? $request->art_record_user_id : null,
        ]);

        return response()->json([
            'data' => $travel_guide,
            'status' => true,
            'message' => 'Successfully store new tracking for travel guide',
        ]);
    }

    public function update(Request $request, TrackingTravelGuide $travel_guide)
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


        $travel_guide->update([
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
            'data' => $travel_guide,
            'status' => true,
            'message' => 'Successfully update tracking for travel guide',
        ]);
    }

    public function delete(TrackingTravelGuide $travel_guide)
    {
        $travel_guide->delete();
        return response()->json('travel_guide deleted.');
    }
}
