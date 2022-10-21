<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Supervisor;
use App\Models\Admin\SvSbPivot;
use App\Models\User;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {
        $supervisor = Supervisor::select('id', 'sv_name')->get();

        return response()->json(["data" => $supervisor]);
    }

    public function info($id)
    {
        $supervisor = Supervisor::with([
            'users'
            => function ($q) {
                $q->select('id', 'supervisor_id', 'subordinate_id');
            },
            'users.subordinate'
            => function ($q) {
                $q->select('id', 'name');
            },
        ])
            ->select('supervisors.id', 'supervisors.sv_name', 'supervisors.user_id')
            // ->join('users', 'sv_sb_pivots.subordinate_id' , '=', 'users.id')
            ->where('supervisors.id', $id)
            ->get();
        return response()->json(["data" => $supervisor]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'int'],
        ], [
            'user_id.required' => 'Please select a user.',
        ]);

        $sv_name = User::where('id','=',$request->user_id)->value('name');

        echo($sv_name);

        $supervisor = Supervisor::create([
            'user_id' => $request->user_id,
            'sv_name' => $sv_name,
        ]);

        return response()->json([
            'data' => $supervisor,
            'status' => true,
            'message' => 'Successfully create new supervisor',
        ]);
    }

    public function delete(Supervisor $supervisor)
    {
        $supervisor->delete();
        return response()->json('Supervisor deleted.');
    }

    public function user_remove(SvSbPivot $supervisor)
    {
        $supervisor->delete();
        return response()->json('User has been removed from the selected supervisor.');
    }

    public function user_add(Request $request)
    {
        $request->validate([
            'subordinate_id' => ['required', 'int'],
        ], [
            'subordinate_id.required' => 'Please select a user.',
        ]);

        $subordinate = SvSbPivot::create([
            'supervisor_id' => $request->supervisor_id,
            'subordinate_id' => $request->subordinate_id,
        ]);

        return response()->json([
            'data' => $subordinate,
            'status' => true,
            'message' => 'Successfully added new user under supervisor',
        ]);
    }
}
