<?php

namespace App\Http\Controllers\Api\FollowUp;

use App\Exports\FollowUpExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ToDo\FollowUpRequest;
use App\Http\Resources\FollowUp\FollowUpResource;
use App\Models\FollowUp\FollowUp;
use App\Models\ToDo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FollowUpController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');


        $selectedUser = request('selectedUser');
        $selectedTask = request('selectedTask');

        $selectedDate = request('selectedDate');

        $followup = FollowUp::select([
            'follow_ups.*',
            'users.name as user_name',
            'tasks.name as task_name',
            'contacts.name as contact_name',
        ])
            ->join('contacts', 'follow_ups.contact_id', '=', 'contacts.id')
            ->join('tasks', 'follow_ups.task_id', '=', 'tasks.id')
            ->join('users', 'follow_ups.user_id', '=', 'users.id')
            ->when($selectedTask, function ($query) use ($selectedTask) {
                $query->where('follow_ups.task_id', $selectedTask);
            })
            ->when($selectedUser, function ($query) use ($selectedUser) {
                $query->where('follow_ups.user_id', $selectedUser);
            })
            ->when($selectedDate, function ($query) use ($selectedDate) {
                $query->whereDate('follow_ups.followup_date', ('='), ($selectedDate));
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->paginate($paginate);

        return FollowUpResource::collection($followup);
    }

    public function monthrange()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedUser = request('selectedUser');
        $selectedTask = request('selectedTask');

        $selectedMonth = request('selectedMonth');
        $selectedYear = request('selectedYear');

        $followup = FollowUp::select([
            'follow_ups.*',
            'users.name as user_name',
            'tasks.name as task_name',
            'contacts.name as contact_name',
        ])
            ->join('contacts', 'follow_ups.contact_id', '=', 'contacts.id')
            ->join('tasks', 'follow_ups.task_id', '=', 'tasks.id')
            ->join('users', 'follow_ups.user_id', '=', 'users.id')
            ->when($selectedTask, function ($query) use ($selectedTask) {
                $query->where('follow_ups.task_id', $selectedTask);
            })
            ->when($selectedUser, function ($query) use ($selectedUser) {
                $query->where('follow_ups.user_id', $selectedUser);
            })
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                $query->whereMonth('follow_ups.followup_date', '=', ($selectedMonth));
            })
            ->when($selectedYear, function ($query) use ($selectedYear) {
                $query->whereYear('follow_ups.followup_date', '=', ($selectedYear));
            })

            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->paginate($paginate);

        return FollowUpResource::collection($followup);
    }

    public function daterange()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedUser = request('selectedUser');
        $selectedTask = request('selectedTask');

        $selectedDateStart = request('selectedDateStart');
        $selectedDateEnd = request('selectedDateEnd');

        $followup = FollowUp::select([
            'follow_ups.*',
            'users.name as user_name',
            'tasks.name as task_name',
            'contacts.name as contact_name',
        ])
            ->join('contacts', 'follow_ups.contact_id', '=', 'contacts.id')
            ->join('tasks', 'follow_ups.task_id', '=', 'tasks.id')
            ->join('users', 'follow_ups.user_id', '=', 'users.id')
            ->when($selectedTask, function ($query) use ($selectedTask) {
                $query->where('follow_ups.task_id', $selectedTask);
            })
            ->when($selectedUser, function ($query) use ($selectedUser) {
                $query->where('follow_ups.user_id', $selectedUser);
            })
            ->when($selectedDateStart && $selectedDateEnd, function ($query) use ($selectedDateStart, $selectedDateEnd) {
                $query->whereBetween('follow_ups.followup_date', [$selectedDateStart, $selectedDateEnd]);
            })

            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->paginate($paginate);

        return FollowUpResource::collection($followup);
    }

    public function store(Request $request)
    {
        // $followupTime = ($request->followup_time);
        // // $followupTime = strtotime($request->followup_time);
        // // $followupTime = Carbon::parse($request->followup_time)->format('H:i:s');

        // echo("this is the follow up time: " . $followupTime );
        // echo "<br>";
        // print_r($request->all());

        $request->validate([
            'priority_id' => ['nullable', 'int'],
            'followup_date' => ['required', 'date'],
            // 'followup_time' => ['required'],
            'followup_time' => ['nullable', 'date_format:H:i'],
            'task_id' => ['required', 'int'],
            'followup_remark' => ['nullable', 'string'],
            'contact_id' => ['required', 'int'],
            'user_id' => ['required', 'int'],
            'status_id' => ['required', 'int'],
            'type_id' => ['required', 'int'],
            'todo_id' => ['required', 'int'],
        ], [
            'followup_date.required' => 'The start date is required',
            'task_id.required' => 'Please select the task',
        ]);

        $followup = FollowUp::create([
                'priority_id' => $request->priority_id,
                'followup_date' => $request->followup_date,
                'followup_time' => $request->followup_time,
                'followup_remark' => $request->followup_remark,
                'contact_id' => $request->contact_id,
                'user_id' => $request->user_id,
                'task_id' => $request->task_id,
                'status_id' => $request->status_id,
                'type_id' => $request->type_id,
                'todo_id' => $request->todo_id,
            ]);

        return response()->json([
            'data' => $followup,
            'status' => true,
            'message' => 'Successfully store new follow up time:',
        ]);

    }

    public function update(Request $request, followup $followup)
    {
        $followup->update([
            'priority_id' => $request->priority_id,
            'follow_ups_created' => $request->follow_ups_created,
            'follow_ups_time' => $request->follow_ups_time ?? "12:00",
            'task_id' => $request->task_id,
            'followup_remark' => $request->followup_remark ?? "No remark",
            'todo_id' => $request->todo_id,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'status_id' => $request->status_id,
            'type_id' => $request->type_id,
        ]);


        return response()->json([
            'status' => true,
            'message' => 'Successfully update data follow up id #' . $followup->id,
            'data' => $followup,
        ]);
    }

    public function action(Request $request, FollowUp $followup)
    {
        $followup->update([
            'action_id' => $request->action_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Successfully update data To Do ' . $followup->id,
            'data' => $followup,
        ]);
    }

    public function delete(FollowUp $followup)
    {
        $followup->delete();
        return response()->json('Follow up deleted.');
    }

    public function info(FollowUp $followup)
    {
        $followup = FollowUp::with('priority', 'type', 'status', 'user', 'contact', 'color', 'task')
            ->where('id', $followup->id)
            ->get();

        $data = $followup->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }

    public function export($followup) 
    {
        $date = Carbon::now()->format('Y-m-d');

        $folowupsArray = explode(',', $followup );

        return Excel::download(new FollowUpExport($folowupsArray), ('Follow Up - '. $date . '.xlsx'));

    }

    public function selectAll()
    {
        return FollowUp::pluck('id');
    }
}
