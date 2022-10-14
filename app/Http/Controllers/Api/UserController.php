<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\ToDo\ToDo;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
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
