<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToDo\ToDoContactRequest;
use App\Http\Requests\ToDo\ToDoInternalRequest;
use App\Http\Resources\ToDoResource;
use App\Models\ToDo;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedStatus = request('selectedStatus');

        $selectedDate = request('selectedDate');
        $selectedMonth = request('selectedMonth');
        $selectedYear = request('selectedYear');

        $selectedDateStart = request('selectedDateStart');
        $selectedDateEnd = request('selectedDateEnd');

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
            ->join('to_do_sources', 'to_dos.source_id', '=', 'to_do_sources.id')
            ->leftJoin('actions', 'to_dos.action_id', '=', 'actions.id')
            ->when($selectedStatus, function ($query) use ($selectedStatus) {
                $query->where('to_dos.status_id', $selectedStatus);
            })
            ->when($selectedDate, function ($query) use ($selectedDate) {
                $query->whereDate('to_dos.todo_created', ('='), ($selectedDate));
            })
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                $query->whereMonth('to_dos.todo_created', ('='), ($selectedMonth));
            })
            ->when($selectedYear, function ($query) use ($selectedYear) {
                $query->whereYear('to_dos.todo_created', ('='), ($selectedYear));
            })
            ->when($selectedDateStart && $selectedDateEnd, function ($query) use ($selectedDateStart, $selectedDateEnd) {
                $query->whereBetween('to_dos.todo_created', [$selectedDateStart, $selectedDateEnd]);
            })

            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->paginate($paginate);

        return ToDoResource::collection($todo);
    }

    public function store(ToDoInternalRequest $request)
    {
        $todo = ToDo::create($request->validated());

        return response()->json([
            'data' => $todo,
            'status' => true,
            'message' => 'Successfully store employee',
        ]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'todo_created' => 'required', 'date',
            'contact_id' => 'required', 'int',
            'user_id' => 'required', 'int',
            'task_id' => 'required', 'int',
        ], [
            'todo_created.required' => 'The date is required',
            'task_id.required' => 'The task is required.'
        ]);

        $todo = ToDo::create([
            'priority_id' => $request->priority_id,
            'todo_created' => $request->todo_created,
            'todo_deadline' => $request->todo_deadline ?? '2000-01-01',
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
        $todo = ToDo::find($id);
        return response()->json(['data' => $todo]);
    }

    public function new(ToDo $todo)
    {
        return new ToDoResource($todo);
    }

    public function update(Request $request, ToDo $todo)
    {
        $todo->update([
            'priority_id' => $request->priority_id,
            'date_created' => $request->todo_created,
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
}
