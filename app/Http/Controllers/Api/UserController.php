<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\Admin\Announcement;
use App\Models\Admin\SvSbPivot;
use App\Models\ToDo\ToDo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

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

    public function manage_list()
    {
        $user = User::with(['roles' => function ($query) {
            $query
                ->select(
                    'id',
                    'name',
                )
                ->get();
        }])
            ->select('id', 'name', 'password', 'email')
            ->orderBy('name')
            ->get()
            ->makeVisible(['password']);;

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
    }

    public function performance_year() //by one year
    {

        $selectedUser = request('selectedUser');
        // return $user;

        //test 4

        $performances = ToDo::select(
            DB::raw('DATE_FORMAT(todo_date, "%Y") as year'),
            DB::raw('MONTH(todo_date) as month'),
            DB::raw('DATE_FORMAT(todo_date, "%M") as bulan'),
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
            ->groupBy('action_name')
            // ->groupBy('week')
            // ->groupBy('action_total')
        ;

        // foreach($performances as $performance){
        //     $arr = [];
        //     $count = "";
        //     $performance->groupBy(
        //         fn ($query) => array_push($arr, $query->action_id)

        //     );
        //     $count = count($arr);

        //     return $performance;
        // }

        return response()->json([
            'status' => true,
            'message' => 'Successfully get user performance',
            'data' => $performances,
        ]);
    }

    public function performance() //by one month (weekly summary of data)
    {
        $selectedUser = request('selectedUser');
        // $selectedWeek = request('selectedWeek');
        $selectedStartDate = request('selectedStartDate');
        $selectedEndDate = request('selectedEndDate');
        $selectedMonth = request('selectedMonth');
        $selectedYear = request('selectedYear');
        $viewType = request('viewType');

        if ($viewType === 'week') {

            //get all todo with action from specific user

            $performances = ToDo::with('action', 'user')
                ->where('user_id', $selectedUser)
                ->whereNotNull('action_id')
                ->when($selectedStartDate && $selectedEndDate, function ($query) use ($selectedStartDate, $selectedEndDate) {
                    $query->whereBetween('to_dos.todo_date', [$selectedStartDate, $selectedEndDate]);
                })
                ->orderBy('todo_date')
                ->get(); //collection of data


            //group the action by week and action type

            $groupBy = $performances->groupBy(
                fn ($summary_action) => \Carbon\Carbon::create($summary_action->todo_date)->format('Y-m-d')
            );

            $new_group = $groupBy->transform(function ($todo_group_daily) {

                $action_group = $todo_group_daily->groupBy('action.name');

                return $action_group->transform(function ($actions) {
                    //sum of the each action type
                    return $actions->count();
                });
            });

            // dd($new_group);

            return response()->json([
                'status' => true,
                'message' => 'Successfully get user performance',
                'data' => $new_group,
            ]);;
        } else if ($viewType === 'month') {

            //get all todo with action from specific user
            $performances = ToDo::with('action', 'user')
                ->where('user_id', $selectedUser)
                ->whereNotNull('action_id')
                ->when($selectedMonth, function ($query) use ($selectedMonth) {
                    $query->whereMonth('to_dos.todo_date', '=', ($selectedMonth));
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereYear('to_dos.todo_date', '=', ($selectedYear));
                })
                ->orderBy('todo_date')
                ->get() //collection of data
            ;

            //group the action by week and action type

            $groupByWeek = $performances->groupBy(
                fn ($summary_action) => \Carbon\Carbon::create($summary_action->todo_date)->format('W')
            );

            $new_group = $groupByWeek->transform(function ($todo_group_weekly) {

                $action_group = $todo_group_weekly->groupBy('action.name');

                return $action_group->transform(function ($actions) {
                    //sum of the each action type
                    return $actions->count();
                });
            });

            // dd($new_group);

            return response()->json([
                'status' => true,
                'message' => 'Successfully get user performance',
                'data' => $new_group,
            ]);
            // } else if ($viewType = 'year') {
        } else {
            //get all todo with action from specific user
            $performances = ToDo::with('action', 'user')
                ->where('user_id', $selectedUser)
                ->whereNotNull('action_id')
                ->whereYear('to_dos.todo_date', '=', $selectedYear)
                ->orderBy('todo_date')
                ->get() //collection of data
            ;


            //group the action by week and month and action type

            $groupByWeek = $performances->groupBy(
                fn ($summary_action) => \Carbon\Carbon::create($summary_action->todo_date)->format('W')
            );

            //group by month

            // $groupByMonth = $groupByWeek->groupBy(
            //     fn ($summary_action) => \Carbon\Carbon::create($summary_action->todo_date)->format('Y-m')
            // );

            // $new_group = $groupByMonth->transform(function ($todo_group_weekly) {

            $new_group = $groupByWeek->transform(function ($todo_group_weekly) {

                $action_group = $todo_group_weekly->groupBy('action.name');

                return $action_group->transform(function ($actions) {
                    //sum of the each action type
                    return $actions->count();
                });
            });

            // dd($performances);

            return response()->json([
                'status' => true,
                'message' => 'Successfully get user performance',
                'data' => $new_group,
            ]);
        }
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

    public function check_subordinate(Request $request)
    {
        // $id = Auth::id();
        $id = 2;

        $contact_user_id = $request->contact_user_id;

        $true = array("id" => 1, "result" => "true");
        $false = array("id" => 2, "result" => "false");

        // check if the $id is supervisor

        //if no, return false
        if (!(SvSbPivot::where('supervisor_id', '=', $id)->exists())) {
            return response()->json([
                'data' => $false,
                'status' => true,
                'message' => 'Not a supervisor/admin.',
            ]);
        } else {
            //if yes,
            //check if the request user_id is subordinate,
            if ((SvSbPivot::where('subordinate_id', '=', $contact_user_id)
                ->where('supervisor_id', '=', $id)->exists())) {
                //if yes return true
                return response()->json([
                    'data' => $true,
                    'status' => true,
                    'message' => 'This user is under this user.',
                ]);
            } else {
                //if no, return false
                return response()->json([
                    'data' => $false,
                    'status' => true,
                    'message' => 'This user is NOT under this user.',
                ]);
            }
        }
    }

    public function user_home()
    {
        // $id = Auth::id();

        $user = User::where('id', 1)->with(['roles' => function ($q) {
            $q->select('id', 'name');
        }, 'reminder'])->select('id', 'name')->get();

        $announcement = Announcement::where('message_type_id', 1)->with('from_user')->get();

        return response()->json([
            'data' => $user, 'data2' => $announcement,
            'status' => true,
            'message' => 'User home page info received',
        ]);
    }
}
