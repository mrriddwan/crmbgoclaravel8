<?php

namespace App\Http\Controllers\Api\Tracking;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tracking\TrackingTGuideResource;
use App\Models\Tracking\TrackingTravelGuide;
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
                            ]
                            );
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
                            )->join('users', 'wip_travel_guides.wip_package_user_id', '=', 'users.id');
                        },
                    ])
                    ->when($selectedUser, function ($query) use ($selectedUser) {
                        $query->where('tracking_travel_guides.user_id', $selectedUser);
                    })
                    ->orderBy($sort_field, $sort_direction)
                    ->search(trim($search_term))
                    ->paginate($paginate)
                    ;
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
                    )->join('users', 'wip_travel_guides.wip_package_user_id', '=', 'users.id');
                },
            ])
            ->where('id', '=', $id)
            ->get();

        return TrackingTGuideResource::collection($travel_guide);
    }
}
