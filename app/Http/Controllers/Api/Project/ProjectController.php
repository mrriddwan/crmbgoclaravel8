<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Admin\SvSbPivot;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');


        $searchStartDate = request('searchStartDate');
        $searchEndDate = request('searchEndDate');
        $searchDuration = request('searchDuration');
        $searchEntryDate = request('searchEntryDate');

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
            $project = Project::select([
                'projects.*',
                'users.name as user_name',
                'contacts.name as contact_name',
            ])
                ->join('contacts', 'projects.contact_id', '=', 'contacts.id')
                ->join('users', 'projects.user_id', '=', 'users.id')
                ->when($searchStartDate, function ($query) use ($searchStartDate) {
                    $query->where('projects.project_startdate', $searchStartDate);
                })
                ->when($searchEndDate, function ($query) use ($searchEndDate) {
                    $query->where('projects.project_enddate', $searchEndDate);
                })
                // ->when($searchDuration, function ($query) use ($searchDuration) {
                //     $query->where('projects.project_duration', $searchDuration);
                // })
                ->when($searchEntryDate, function ($query) use ($searchEntryDate) {
                    $query->where('projects.created_at', $searchEntryDate);
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->distinct()
                ->paginate($paginate);

            return ProjectResource::collection($project);
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


            $project = Project::select([
                'projects.*',
                'users.name as user_name',
                'contacts.name as contact_name',
            ])
                ->whereIn('projects.user_id', $final) // for view under supervisor and the subordinates
                ->join('contacts', 'projects.contact_id', '=', 'contacts.id')
                ->join('users', 'projects.user_id', '=', 'users.id')
                ->when($searchStartDate, function ($query) use ($searchStartDate) {
                    $query->where('projects.project_startdate', $searchStartDate);
                })
                ->when($searchEndDate, function ($query) use ($searchEndDate) {
                    $query->where('projects.project_enddate', $searchEndDate);
                })
                // ->when($searchDuration, function ($query) use ($searchDuration) {
                //     $query->where('projects.project_duration', $searchDuration);
                // })
                ->when($searchEntryDate, function ($query) use ($searchEntryDate) {
                    $query->where('projects.created_at', $searchEntryDate);
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->distinct()
                ->paginate($paginate);

            return ProjectResource::collection($project);
        }
    }

    // public function list (){
    //     $project = project::select('id', 'name')->orderBy('name')->get();

    //     return response()->json([
    //         'data' => $project,
    //         'status' => true,
    //         'message' => 'Successfully retrieve list of projects',
    //     ]);
    // }

    public function store(ProjectRequest $request)
    {

        $project = Project::create([
            'project_startdate' => $request->project_startdate,
            'project_enddate' => $request->project_enddate,
            // 'project_duration' => $request->project_duration,
            'project_name' => $request->project_name,
            'project_remark' => $request->project_remark,
            'user_id' => Auth::id(),
            'contact_id' => $request->contact_id,
        ]);

        return response()->json([
            'data' => $project,
            'status' => true,
            'message' => 'Successfully store project',
        ]);
    }
    public function show($id)
    {
        $project = Project::find($id);
        return response()->json(["data" => $project]);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $project->update([
            'project_startdate' => $request->project_startdate,
            'project_enddate' => $request->project_enddate,
            // 'project_duration' => $request->project_duration,
            'project_name' => $request->project_name,
            'project_remark' => $request->project_remark,
            // 'user_id' => $request->user_id ?? 1, //change to current user later
            'user_id' => Auth::id(),
            'contact_id' => $request->contact_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data project ' . $project->name,
            'data' => $project,
        ]);
    }

    public function delete(Project $project)
    {
        $project->delete();
        return response()->json('project deleted.');
    }

    // public function info(Project $project)
    // {   
    //     $project = Project::with('type', 'product', 'contact', 'user', 'result')
    //             ->where('id', $project->id)
    //             ->get();

    //     $data = $project->toArray();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Successfully fetch data project ',
    //         'data' => $data,
    //     ]);
    // }
}
