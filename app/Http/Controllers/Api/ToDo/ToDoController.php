<?php

namespace App\Http\Controllers\Api\ToDo;

use App\Exports\ForecastExport;
use App\Exports\TodoExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ToDo\ToDoContactRequest;
use App\Http\Requests\ToDo\ToDoInternalRequest;
use App\Http\Resources\ToDo\ToDoResource;
use App\Models\Admin\SvSbPivot;
use App\Models\ToDo\ToDo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ToDoController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedSource = request('selectedSource');
        $selectedStatus = request('selectedStatus');
        // $selectedContact = request('selectedContact');
        $selectedUser = request('selectedUser');
        $selectedTask = request('selectedTask');
        $selectedType = request('selectedType');

        $selectedDate = request('selectedDate');

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
            $todo = ToDo::select([
                'to_dos.*',
                'contacts.id as contact_id',
                'contacts.name as contact_name',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'tasks.name as task_name',
                'priorities.name as priority_name',
                'text_colors.color_code as color_name',
                'contacts.type_id as contact_type_id',
                'contacts.status_id as contact_status_id',
                // 'contacts.name as contact_name',
                'to_do_sources.name as source_name',
                'actions.name as action_name',
            ])
                ->join('contacts', 'to_dos.contact_id', '=', 'contacts.id')
                ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                // ->join('contact_types', 'to_dos.type_id', '=', 'contact_types.id')
                ->join('tasks', 'to_dos.task_id', '=', 'tasks.id')
                ->join('priorities', 'to_dos.priority_id', '=', 'priorities.id')
                ->join('users', 'to_dos.user_id', '=', 'users.id')
                ->join('text_colors', 'to_dos.color_id', '=', 'text_colors.id')
                ->leftJoin('to_do_sources', 'to_dos.source_id', '=', 'to_do_sources.id')
                ->leftJoin('actions', 'to_dos.action_id', '=', 'actions.id')
                ->when($selectedStatus, function ($query) use ($selectedStatus) {
                    $query->where('to_dos.status_id', $selectedStatus);
                })
                // ->when($selectedContact, function ($query) use ($selectedContact) {
                //     $query->where('to_dos.contact_id', $selectedContact);
                // })
                ->when($selectedSource, function ($query) use ($selectedSource) {
                    $query->where('to_dos.source_id', $selectedSource);
                })
                ->when($selectedTask, function ($query) use ($selectedTask) {
                    $query->where('to_dos.task_id', $selectedTask);
                })
                ->when($selectedType, function ($query) use ($selectedType) {
                    $query->where('to_dos.type_id', $selectedType);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('to_dos.user_id', $selectedUser);
                })
                ->when($selectedDate, function ($query) use ($selectedDate) {
                    $query->whereDate('to_dos.todo_date', ('='), ($selectedDate));
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);

            return ToDoResource::collection($todo);
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

            $todo = ToDo::select([
                'to_dos.*',
                'contacts.id as contact_id',
                'contacts.name as contact_name',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'tasks.name as task_name',
                'priorities.name as priority_name',
                'text_colors.color_code as color_name',
                'contacts.type_id as contact_type_id',
                'contacts.status_id as contact_status_id',
                // 'contacts.name as contact_name',
                'to_do_sources.name as source_name',
                'actions.name as action_name',
            ])
                ->whereIn('to_dos.user_id', $final) // for view under supervisor and the subordinates

                ->join('contacts', 'to_dos.contact_id', '=', 'contacts.id')
                ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                // ->join('contact_types', 'to_dos.type_id', '=', 'contact_types.id')
                ->join('tasks', 'to_dos.task_id', '=', 'tasks.id')
                ->join('priorities', 'to_dos.priority_id', '=', 'priorities.id')
                ->join('users', 'to_dos.user_id', '=', 'users.id')
                ->join('text_colors', 'to_dos.color_id', '=', 'text_colors.id')
                ->leftJoin('to_do_sources', 'to_dos.source_id', '=', 'to_do_sources.id')
                ->leftJoin('actions', 'to_dos.action_id', '=', 'actions.id')
                ->when($selectedStatus, function ($query) use ($selectedStatus) {
                    $query->where('to_dos.status_id', $selectedStatus);
                })
                // ->when($selectedContact, function ($query) use ($selectedContact) {
                //     $query->where('to_dos.contact_id', $selectedContact);
                // })
                ->when($selectedSource, function ($query) use ($selectedSource) {
                    $query->where('to_dos.source_id', $selectedSource);
                })
                ->when($selectedTask, function ($query) use ($selectedTask) {
                    $query->where('to_dos.task_id', $selectedTask);
                })
                ->when($selectedType, function ($query) use ($selectedType) {
                    $query->where('to_dos.type_id', $selectedType);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('to_dos.user_id', $selectedUser);
                })
                ->when($selectedDate, function ($query) use ($selectedDate) {
                    $query->whereDate('to_dos.todo_date', ('='), ($selectedDate));
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);

            return ToDoResource::collection($todo);
        }
    }

    public function monthrange()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedSource = request('selectedSource');
        $selectedStatus = request('selectedStatus');
        $selectedUser = request('selectedUser');
        $selectedTask = request('selectedTask');
        $selectedType = request('selectedType');

        $selectedMonth = request('selectedMonth');
        $selectedYear = request('selectedYear');

        $id = Auth::id();

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
            $todo = ToDo::select([
                'to_dos.*',
                'contacts.id as contact_id',
                'contacts.name as contact_name',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'tasks.name as task_name',
                'priorities.name as priority_name',
                'text_colors.color_code as color_name',
                'contacts.type_id as contact_type_id',
                'contacts.status_id as contact_status_id',
                // 'contacts.name as contact_name',
                'to_do_sources.name as source_name',
                'actions.name as action_name',
            ])
                ->join('contacts', 'to_dos.contact_id', '=', 'contacts.id')
                ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                // ->join('contact_types', 'to_dos.type_id', '=', 'contact_types.id')
                ->join('tasks', 'to_dos.task_id', '=', 'tasks.id')
                ->join('priorities', 'to_dos.priority_id', '=', 'priorities.id')
                ->join('users', 'to_dos.user_id', '=', 'users.id')
                ->join('text_colors', 'to_dos.color_id', '=', 'text_colors.id')
                ->leftJoin('to_do_sources', 'to_dos.source_id', '=', 'to_do_sources.id')
                ->leftJoin('actions', 'to_dos.action_id', '=', 'actions.id')
                ->when($selectedStatus, function ($query) use ($selectedStatus) {
                    $query->where('to_dos.status_id', $selectedStatus);
                })
                // ->when($selectedContact, function ($query) use ($selectedContact) {
                //     $query->where('to_dos.contact_id', $selectedContact);
                // })
                ->when($selectedSource, function ($query) use ($selectedSource) {
                    $query->where('to_dos.source_id', $selectedSource);
                })
                ->when($selectedTask, function ($query) use ($selectedTask) {
                    $query->where('to_dos.task_id', $selectedTask);
                })
                ->when($selectedType, function ($query) use ($selectedType) {
                    $query->where('to_dos.type_id', $selectedType);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('to_dos.user_id', $selectedUser);
                })
                ->when($selectedMonth, function ($query) use ($selectedMonth) {
                    $query->whereMonth('to_dos.todo_date', '=', ($selectedMonth));
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereYear('to_dos.todo_date', '=', ($selectedYear));
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);

            return ToDoResource::collection($todo);
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

            $todo = ToDo::select([
                'to_dos.*',
                'contacts.id as contact_id',
                'contacts.name as contact_name',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'tasks.name as task_name',
                'priorities.name as priority_name',
                'text_colors.color_code as color_name',
                'contacts.type_id as contact_type_id',
                'contacts.status_id as contact_status_id',
                // 'contacts.name as contact_name',
                'to_do_sources.name as source_name',
                'actions.name as action_name',
            ])
                ->whereIn('to_dos.user_id', $final) // for view under supervisor and the subordinates

                ->join('contacts', 'to_dos.contact_id', '=', 'contacts.id')
                ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                // ->join('contact_types', 'to_dos.type_id', '=', 'contact_types.id')
                ->join('tasks', 'to_dos.task_id', '=', 'tasks.id')
                ->join('priorities', 'to_dos.priority_id', '=', 'priorities.id')
                ->join('users', 'to_dos.user_id', '=', 'users.id')
                ->join('text_colors', 'to_dos.color_id', '=', 'text_colors.id')
                ->leftJoin('to_do_sources', 'to_dos.source_id', '=', 'to_do_sources.id')
                ->leftJoin('actions', 'to_dos.action_id', '=', 'actions.id')
                ->when($selectedStatus, function ($query) use ($selectedStatus) {
                    $query->where('to_dos.status_id', $selectedStatus);
                })
                // ->when($selectedContact, function ($query) use ($selectedContact) {
                //     $query->where('to_dos.contact_id', $selectedContact);
                // })
                ->when($selectedSource, function ($query) use ($selectedSource) {
                    $query->where('to_dos.source_id', $selectedSource);
                })
                ->when($selectedTask, function ($query) use ($selectedTask) {
                    $query->where('to_dos.task_id', $selectedTask);
                })
                ->when($selectedType, function ($query) use ($selectedType) {
                    $query->where('to_dos.type_id', $selectedType);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('to_dos.user_id', $selectedUser);
                })
                ->when($selectedMonth, function ($query) use ($selectedMonth) {
                    $query->whereMonth('to_dos.todo_date', '=', ($selectedMonth));
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereYear('to_dos.todo_date', '=', ($selectedYear));
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);

            return ToDoResource::collection($todo);
        }
    }


    public function daterange()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedSource = request('selectedSource');
        $selectedStatus = request('selectedStatus');
        $selectedUser = request('selectedUser');
        $selectedTask = request('selectedTask');
        $selectedType = request('selectedType');

        $selectedDateStart = request('selectedDateStart');
        $selectedDateEnd = request('selectedDateEnd');

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
            $todo = ToDo::select([
                'to_dos.*',
                'contacts.id as contact_id',
                'contacts.name as contact_name',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'tasks.name as task_name',
                'priorities.name as priority_name',
                'text_colors.color_code as color_name',
                'contacts.type_id as contact_type_id',
                'contacts.status_id as contact_status_id',
                // 'contacts.name as contact_name',
                'to_do_sources.name as source_name',
                'actions.name as action_name',
            ])
                ->join('contacts', 'to_dos.contact_id', '=', 'contacts.id')
                ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                // ->join('contact_types', 'to_dos.type_id', '=', 'contact_types.id')
                ->join('tasks', 'to_dos.task_id', '=', 'tasks.id')
                ->join('priorities', 'to_dos.priority_id', '=', 'priorities.id')
                ->join('users', 'to_dos.user_id', '=', 'users.id')
                ->join('text_colors', 'to_dos.color_id', '=', 'text_colors.id')
                ->leftJoin('to_do_sources', 'to_dos.source_id', '=', 'to_do_sources.id')
                ->leftJoin('actions', 'to_dos.action_id', '=', 'actions.id')
                ->when($selectedStatus, function ($query) use ($selectedStatus) {
                    $query->where('to_dos.status_id', $selectedStatus);
                })
                // ->when($selectedContact, function ($query) use ($selectedContact) {
                //     $query->where('to_dos.contact_id', $selectedContact);
                // })
                ->when($selectedSource, function ($query) use ($selectedSource) {
                    $query->where('to_dos.source_id', $selectedSource);
                })
                ->when($selectedTask, function ($query) use ($selectedTask) {
                    $query->where('to_dos.task_id', $selectedTask);
                })
                ->when($selectedType, function ($query) use ($selectedType) {
                    $query->where('to_dos.type_id', $selectedType);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('to_dos.user_id', $selectedUser);
                })
                ->when($selectedDateStart && $selectedDateEnd, function ($query) use ($selectedDateStart, $selectedDateEnd) {
                    $query->whereBetween('to_dos.todo_date', [$selectedDateStart, $selectedDateEnd]);
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);

            return ToDoResource::collection($todo);
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

            $todo = ToDo::select([
                'to_dos.*',
                'contacts.id as contact_id',
                'contacts.name as contact_name',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'tasks.name as task_name',
                'priorities.name as priority_name',
                'text_colors.color_code as color_name',
                'contacts.type_id as contact_type_id',
                'contacts.status_id as contact_status_id',
                // 'contacts.name as contact_name',
                'to_do_sources.name as source_name',
                'actions.name as action_name',
            ])
                ->whereIn('to_dos.user_id', $final) // for view under supervisor and the subordinates

                ->join('contacts', 'to_dos.contact_id', '=', 'contacts.id')
                ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                // ->join('contact_types', 'to_dos.type_id', '=', 'contact_types.id')
                ->join('tasks', 'to_dos.task_id', '=', 'tasks.id')
                ->join('priorities', 'to_dos.priority_id', '=', 'priorities.id')
                ->join('users', 'to_dos.user_id', '=', 'users.id')
                ->join('text_colors', 'to_dos.color_id', '=', 'text_colors.id')
                ->leftJoin('to_do_sources', 'to_dos.source_id', '=', 'to_do_sources.id')
                ->leftJoin('actions', 'to_dos.action_id', '=', 'actions.id')
                ->when($selectedStatus, function ($query) use ($selectedStatus) {
                    $query->where('to_dos.status_id', $selectedStatus);
                })
                // ->when($selectedContact, function ($query) use ($selectedContact) {
                //     $query->where('to_dos.contact_id', $selectedContact);
                // })
                ->when($selectedSource, function ($query) use ($selectedSource) {
                    $query->where('to_dos.source_id', $selectedSource);
                })
                ->when($selectedTask, function ($query) use ($selectedTask) {
                    $query->where('to_dos.task_id', $selectedTask);
                })
                ->when($selectedType, function ($query) use ($selectedType) {
                    $query->where('to_dos.type_id', $selectedType);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('to_dos.user_id', $selectedUser);
                })
                ->when($selectedDateStart && $selectedDateEnd, function ($query) use ($selectedDateStart, $selectedDateEnd) {
                    $query->whereBetween('to_dos.todo_date', [$selectedDateStart, $selectedDateEnd]);
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate($paginate);

            return ToDoResource::collection($todo);
        }
    }


    public function store(ToDoInternalRequest $request)
    {
        $todo = ToDo::create([
            'priority_id' => $request->priority_id,
            'todo_date' => Carbon::parse($request->todo_date)->toDate(),
            'todo_deadline' => Carbon::parse($request->todo_deadline)->toDate() ?? '2000-01-01',
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
            'status_id' => $request->status_id,
            'type_id' => $request->type_id,
            'todo_remark' => $request->todo_remark ?? "None",
            'color_id' => $request->color_id ?? '1',
            'source_id' => $request->source_id
        ]);

        return response()->json([
            'data' => $todo,
            'status' => true,
            'message' => 'Successfully store employee',
        ]);
    }

    public function remark(ToDo $todo)
    {
        $todo = ToDo::where('id', $todo->id)
            ->select('todo_remark')
            ->get();

        $data = $todo->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'todo_date' => 'required', 'date',
            'contact_id' => 'required', 'int',
            'user_id' => 'required', 'int',
            'task_id' => 'required', 'int',
        ], [
            'todo_date.required' => 'The date is required',
            'task_id.required' => 'The task is required.'
        ]);

        $todo = ToDo::create([
            'priority_id' => $request->priority_id,
            'todo_date' => Carbon::parse($request->todo_date)->toDate(),
            'todo_deadline' => Carbon::parse($request->todo_deadline)->toDate() ?? '2000-01-01',
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
            'status_id' => $request->status_id,
            'type_id' => $request->type_id,
            'todo_remark' => $request->todo_remark ?? "None",
            'color_id' => $request->color_id ?? '1',
            'source_id' => $request->source_id
        ]);

        return response()->json([
            'data' => $todo,
            'status' => true,
            'message' => 'Successfully store employee',
        ]);
    }
    public function show($id)
    {
        // $todo = ToDo::find($id);
        // return response()->json(['data' => $todo]);

        // ['contact' => function($q){
        //     $q->select();
        // }]
        $todo = ToDo::select(
            'to_dos.*',
            'contact_statuses.id as contact_status_id',
            'contact_types.id as contact_type_id',
        )
            ->join('contacts', 'to_dos.contact_id', '=', 'contacts.id')
            ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
            ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
            // ->with(['contact' => function ($q) {
            //     $q->select('id', 'status_id', 'type_id');
            // }])
            ->where('to_dos.id', '=', $id)
            ->get()
            ;

        return response()->json(['data' => $todo[0]]);
    }

    public function new(ToDo $todo)
    {
        return new ToDoResource($todo);
    }

    public function update(Request $request, ToDo $todo)
    {
        $todo->update([
            'priority_id' => $request->priority_id,
            'todo_date' => $request->todo_date,
            'todo_deadline' => $request->todo_deadline,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
            'status_id' => $request->status_id,
            'type_id' => $request->type_id,
            'todo_remark' => $request->todo_remark,
        ]);


        return response()->json([
            'status' => true,
            'message' => 'Successfully update data To Do ' . $todo->id,
            'data' => $todo,
        ]);
    }

    public function action(Request $request, ToDo $todo)
    {
        $todo->update([
            'action_id' => $request->action_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Successfully update data To Do ' . $todo->id,
            'data' => $todo,
        ]);
    }

    public function delete(ToDo $todo)
    {
        $todo->delete();
        return response()->json('Contact deleted.');
    }

    public function info(ToDo $todo)
    {
        $todo = ToDo::with('priority', 'type', 'status', 'user', 'contact', 'color', 'task')
            ->where('id', $todo->id)
            ->get();

        $data = $todo->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }

    public function export($todo)
    {

        $date = Carbon::now()->format('Ymd');

        $todoArray = explode(',', $todo);

        // return Excel::download(new TodoExport($forecastsArray), ('ToDo - ' . $date . '.xlsx'));
        return (new TodoExport($todoArray))->download('To Do - ' . $date . '.xlsx');
    }

    public function selectAll()
    {
        return ToDo::pluck('id');
    }

    public function test_api()
    {
        $todo = ToDo::select([
            'to_dos.*',
            'contact_statuses.name as status_name',
            'contact_types.name as type_name',
            'users.name as user_name',
            'tasks.name as task_name',
            'priorities.name as priority_name',
            'text_colors.color_code as color_name',
            'contacts.name as contact_name',
            'to_do_sources.name as source_name',
            'actions.name as action_name',
        ])
            ->join('contacts', 'to_dos.contact_id', '=', 'contacts.id')
            ->join('contact_statuses', 'to_dos.status_id', '=', 'contact_statuses.id')
            ->join('contact_types', 'to_dos.type_id', '=', 'contact_types.id')
            ->join('tasks', 'to_dos.task_id', '=', 'tasks.id')
            ->join('priorities', 'to_dos.priority_id', '=', 'priorities.id')
            ->join('users', 'to_dos.user_id', '=', 'users.id')
            ->join('text_colors', 'to_dos.color_id', '=', 'text_colors.id')
            ->leftJoin('to_do_sources', 'to_dos.source_id', '=', 'to_do_sources.id')
            ->leftJoin('actions', 'to_dos.action_id', '=', 'actions.id')
            // ->when($selectedStatus, function ($query) use ($selectedStatus) {
            //     $query->where('to_dos.status_id', $selectedStatus);
            // })
            // // ->when($selectedContact, function ($query) use ($selectedContact) {
            // //     $query->where('to_dos.contact_id', $selectedContact);
            // // })
            // ->when($selectedSource, function ($query) use ($selectedSource) {
            //     $query->where('to_dos.source_id', $selectedSource);
            // })
            // ->when($selectedTask, function ($query) use ($selectedTask) {
            //     $query->where('to_dos.task_id', $selectedTask);
            // })
            // ->when($selectedType, function ($query) use ($selectedType) {
            //     $query->where('to_dos.type_id', $selectedType);
            // })
            // ->when($selectedUser, function ($query) use ($selectedUser) {
            //     $query->where('to_dos.user_id', $selectedUser);
            // })
            // ->when($selectedDateStart && $selectedDateEnd, function ($query) use ($selectedDateStart, $selectedDateEnd) {
            //     $query->whereBetween('to_dos.todo_date', [$selectedDateStart, $selectedDateEnd]);
            // })
            // ->orderBy($sort_field, $sort_direction)
            // ->search(trim($search_term))
            // ->paginate($paginate);
            ->paginate(5000);

        return ToDoResource::collection($todo);
    }
}
