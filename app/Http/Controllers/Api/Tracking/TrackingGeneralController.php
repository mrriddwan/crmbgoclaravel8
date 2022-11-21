<?php

namespace App\Http\Controllers\Api\Tracking;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tracking\TrackingGeneralResource;
use App\Models\Admin\SvSbPivot;
use App\Models\Tracking\TrackingGeneral;
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
            $tracking = TrackingGeneral::select([
                'tracking_generals.*',
                'contact_categories.name as category_name',
                'users.name as user_name',
                'contacts.name as company_name',
            ])
                ->join('contacts', 'tracking_generals.company_id', '=', 'contacts.id')
                ->join('contact_categories', 'tracking_generals.contact_category_id', '=', 'contact_categories.id')
                ->join('users', 'tracking_generals.user_id', '=', 'users.id')
                ->when($selectedCategory, function ($query) use ($selectedCategory) {
                    $query->where('to_dos.status_id', $selectedCategory);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('to_dos.user_id', $selectedUser);
                })
                // ->orderBy($sort_field, $sort_direction)
                // ->search(trim($search_term))
                // ->paginate($paginate);
                ->get();

            return TrackingGeneralResource::collection($tracking);
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
}
