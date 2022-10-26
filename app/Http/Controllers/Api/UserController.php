<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\Admin\SvSbPivot;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('name', 'asc')
            ->select('id', 'name')
            ->get()
            ;

        return response()->json([
            'data' => $user,
            'status' => true,
            'message' => 'Successfully store contact',
        ]);
    }

    public function users_list()
    {
        $id = Auth::id();


        if ((DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 2)
                ->exists()) ||
            (DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 1)
                ->exists())
        ) {
            $user = User::select('id', 'name')
                ->orderBy('name', 'asc')
                ->get()
                ->toArray();

            return response()->json([
                'data' => $user,
                'status' => true,
                'message' => 'Successfully store contact',
            ]);
        } else {
            $sv_sb = "";
            $final = [$id];

            $sv_sb = SvSbPivot::select('subordinate_id')
                ->where('supervisor_id', '=', $id)
                ->pluck('subordinate_id');


            array_push($final, ...$sv_sb);

            $user = User::whereIn('id', $final)->select('id', 'name')
                ->orderBy('name', 'asc')
                ->get()
                ->toArray();

            return response()->json([
                'data' => $user,
                'status' => true,
                'message' => 'Successfully store contact',
            ]);
        }


        // $id = 3;
        // $sv_sb = "";
        // $final = [$id];

        // $sv_sb = SvSbPivot::select('subordinate_id')
        //     ->where('supervisor_id', '=', $id)
        //     ->pluck('subordinate_id');


        // array_push($final, ...$sv_sb);

        // return User::whereIn('id', $final)->select('id', 'name')
        //                                 ->orderBy('name', 'asc')
        //                                 ->get()
        //                                 ->toArray();
    }


    public function action(User $user)
    {
        //Query test 1
        $user = User::where('id', 2)
            ->with(['performance' => function ($query) {
                $query->select(
                    'todo_date',
                    'user_id',
                    'action_id',
                )
                    ->with(['action' => function ($query) {
                        $query
                            ->select(
                                'id',
                                'name',
                            )
                            ->get();
                    }])
                    ->latest('todo_date')
                    // ->first()
                    ->get();
            }])
            // ->groupBy('action_id')
            ->select([
                'id',
                'name',
                // 'created_at'
            ])
            // ->where('id', $user->id)
            ->get()
            ->toArray();

        return $user;

        // return $user;



        //QUERY TEST 2
        // $user = User::all();

        // $user = $user->groupBy(function ($user) {
        //     return $user->performance;
        // })->all();

        // return $user;







        // $data =  $user->toArray();

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Successfully fetch data User ',
        //     'data' => $user,
        //     // 'data' => $data,
        // ]);

        // $user = User::with(['action' => function ($query) {
        //     $query->select(['user_id', 'todo_date', 'action_id'])
        //         ->get();
        // }])
        // ->select([
        //     'user.created_at',
        //     'user.id',
        //     'user.name',

        // ]);
    }
}
