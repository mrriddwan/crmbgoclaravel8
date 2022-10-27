<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\Admin\SvSbPivot;
use App\Models\ToDo\ToDo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('name', 'asc')
            ->select('id', 'name')
            ->get();

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

    public function performance() //by weekly / month
    {
        // $paginate = request('paginate');
        // $search_term = request('q', '');

        // $sort_direction = request('sort_direction');
        // $sort_field = request('sort_field');

        // $selectedStatus = request('selectedStatus');
        // $selectedType = request('selectedType');
        $selectedUser = request('selectedUser');
        // $selectedCategory = request('selectedCategory');
        // $selectedIndustry = request('selectedIndustry');
        // $selectedYear = request('selectedYear');

        // $id = Auth::id();

        // if ((DB::table('model_has_roles')
        //         ->where('model_id', '=', $id)
        //         ->where('role_id', '=', 2)
        //         ->exists()) ||
        //     (DB::table('model_has_roles')
        //         ->where('model_id', '=', $id)
        //         ->where('role_id', '=', 1)
        //         ->exists())
        // ) 
        // {
        // $user = User::with(
        //     // 'performance'
        //     [
        //         'performance' => function ($q) {
        //             $q->select(['id', 'todo_date', 'contact_id', 'action_id', 'user_id'])
        //                 ->orderBy('todo_date', 'desc');
        //         },
        //         'performance.action' => function ($q) {
        //             $q->select('actions.id', 'name');
        //         },
        //     ],
        // )
        // ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
        // ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
        // ->join('contact_categories', 'contacts.category_id', '=', 'contact_categories.id')
        // ->join('contact_industries', 'contacts.industry_id', '=', 'contact_industries.id')
        // ->join('users', 'contacts.user_id', '=', 'users.id')
        // ->join('to_dos', 'to_dos.action_id', '=', 'actions.id')
        // ->join('actions', 'to_dos.action_id', '=', 'actions.id')
        // ->select([
        //     'users.id',
        //     'users.name',
        // ])
        // ->when($selectedStatus, function ($query) use ($selectedStatus) {
        //     $query->where('contacts.status_id', $selectedStatus);
        // })
        // ->when($selectedType, function ($query) use ($selectedType) {
        //     $query->where('contacts.type_id', $selectedType);
        // })
        // ->when($selectedUser, function ($query) use ($selectedUser) {
        //     $query->where('contacts.user_id', $selectedUser);
        // })
        // ->when($selectedCategory, function ($query) use ($selectedCategory) {
        //     $query->where('contacts.category_id', $selectedCategory);
        // })
        // ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
        //     $query->where('contacts.industry_id', $selectedIndustry);
        // })
        // ->when($selectedYear, function ($query) use ($selectedYear) {
        //     $query->whereHas('summary_action', function ($q) use ($selectedYear) {
        //         $q->whereYear('todo_date', $selectedYear);
        //     });
        // })
        // ->orderBy($sort_field, $sort_direction)
        // ->search(trim($search_term))
        // ->where('id', $selectedUser)
        // ->get();
        // ->paginate(5000);

        // group smua todo by month
        // $user
        //     ->transform(function ($user_overall) {
        //         $user_overall->setRelation(
        //             'performance',
        //             $user_overall->performance->groupBy(
        //                 // fn ($performance) => \Carbon\Carbon::create($performance->todo_date)->format('W')
        //                 // fn ($performance) => \Carbon\Carbon::create($performance->todo_date)->format('m/Y')
        //                 // function($performance) => 
        //             )
        //         );

        //         return $user_overall;
        //     })
        //     // ->toArray()
        //     ;

        // $user
        // ->transform(function ($user_overall) {
        //     $user_overall->setRelation(
        //         'performance',
        //         $user_overall->performance->groupBy(
        //             fn ($performance) => \Carbon\Carbon::create($performance->todo_date)->format('W')
        //         )
        //     );

        //     return $user_overall;
        // })
        // // ->toArray()
        // ;



        // return $user;

        //test 4

        $performances = ToDo::select(
            DB::raw('MONTH(todo_date) as month'),
            DB::raw('WEEK(todo_date) as week'),
            // DB::raw("SUM(action_id) as action_total"),
            // DB::raw("action_id"),
            'todo_date',
            'users.id as user_id',
            'users.name as user_name',
            'actions.id as action_id',
            'actions.name as action_name',
        )
            ->orderBy('week')
            ->join('actions', 'actions.id', 'to_dos.action_id')
            ->join('users', 'users.id', 'to_dos.user_id')
            // ->with(['action'])
            ->where('user_id', $selectedUser)
            ->get()
            // ->groupBy('week')
            // ->groupBy('month')
            // ->groupBy('action_total')
            ->groupBy('action_name');

        foreach($performances as $performance){
            $performance->groupBy(
                fn ($query) => count($query->action_id)
            );

            return $performance;
        }

        return $performances;



        //test 3

        // $performance = ToDo::select(
        //     // DB::raw('DAYNAME(created_at) AS week_day'),
        //     DB::raw('MONTH(todo_date) as month'),
        //     DB::raw('WEEK(todo_date) as week'),
        //     // DB::raw("SUM(action_id) as action_total"),
        //     // DB::raw("action_id"),
        //     'todo_date',
        //     'users.id as user_id',
        //     'users.name as user_name',
        //     'actions.id as action_id',
        //     'actions.name as action_name',
        // )
        //     ->orderBy('week')
        //     ->join('actions', 'actions.id', 'to_dos.action_id')
        //     ->join('users', 'users.id', 'to_dos.user_id')
        //     // ->with(['action'])
        //     ->where('user_id', $selectedUser)
        //     ->get()
        //     // ->groupBy('week')
        //     // ->groupBy('month')
        //     // ->groupBy('action_total')
        //     ->groupBy('action_name')
        //     ;

        // return $performance;

        //test 2

        // $performance = ToDo::select(
        //     // DB::raw('DAYNAME(created_at) AS week_day'),
        //     // DB::raw('DAY(todo_date) as day'),
        //     DB::raw('WEEK(todo_date) as week'),
        //     DB::raw("SUM(action_id) as action_total"),
        //     // DB::raw("action_id"),
        // )
        //     //   ->orderBy('day')
        //     ->with(['action'])
        //     ->groupBy('week')
        //     ->get();

        // return $performance;


        //test 1    
        // $performance = ToDo::select(
        //     // DB::raw('DAYNAME(created_at) AS week_day'),
        //     // DB::raw('DAY(todo_date) as day'),
        //     DB::raw('WEEK(todo_date) as week'),
        //     DB::raw("SUM(action_id) as action_total")
        //   )
        // //   ->orderBy('day')
        //   ->groupBy('week')
        //   ->get();

        // return $performance;
    }

    public function test()
    {
        $performance = ToDo::select(
            // DB::raw('DAYNAME(created_at) AS week_day'),
            // DB::raw('DAY(todo_date) as day'),
            DB::raw('WEEK(todo_date) as week'),
            DB::raw("SUM(action_id) as action_total")
        )
            //   ->orderBy('day')
            ->groupBy('week')
            ->get();

        return $performance;
    }
}
