<?php

namespace App\Http\Controllers\Api\FollowUp;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToDo\FollowUpRequest;
use App\Http\Resources\FollowUp\FollowUpResource;
use App\Models\FollowUp\FollowUp;
use App\Models\ToDo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FollowUpController extends Controller
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

        $followup = FollowUp::select([
            'follow_ups.*',
            'contact_statuses.name as status_name',
            'contact_types.name as type_name',
            'users.name as user_name',
            'tasks.name as task_name',
            'priorities.name as priority_name',
            'contacts.name as contact_name',
        ])
            ->join('contacts', 'follow_ups.contact_id', '=', 'contacts.id')
            ->join('contact_statuses', 'follow_ups.status_id', '=', 'contact_statuses.id')
            ->join('contact_types', 'follow_ups.type_id', '=', 'contact_types.id')
            ->join('tasks', 'follow_ups.task_id', '=', 'tasks.id')
            ->join('priorities', 'follow_ups.priority_id', '=', 'priorities.id')
            ->join('users', 'follow_ups.user_id', '=', 'users.id')
            ->when($selectedStatus, function ($query) use ($selectedStatus) {
                $query->where('follow_ups.status_id', $selectedStatus);
            })
            ->when($selectedDate, function ($query) use ($selectedDate) {
                $query->whereDate('follow_ups.followup_date', ('='), ($selectedDate));
            })
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                $query->whereMonth('follow_ups.followup_date', ('='), ($selectedMonth));
            })
            ->when($selectedYear, function ($query) use ($selectedYear) {
                $query->whereYear('follow_ups.followup_date', ('='), ($selectedYear));
            })
            ->when($selectedDateStart && $selectedDateEnd, function ($query) use ($selectedDateStart, $selectedDateEnd) {
                $query->whereBetween('follow_ups.followup_date', [$selectedDateStart, $selectedDateEnd]);
            })

            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->paginate($paginate);

        return FollowUpResource::collection($followup);
    }
    // whereDate('created_at', '=', date('Y-m-d'))

    public function store(Request $request)
    {
        // $followupTime = strtotime($request->followup_time);
        $followupTime = Carbon::parse($request->followup_time)->format('H:i:s');

        echo("this is the follow up time: " . $followupTime);

        $request->validate([
            'priority_id' => ['nullable', 'int'],
            'followup_date' => ['required', 'date'],
            'followup_time' => ['required', 'date_format:H:i:s'],
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
                'followup_time' => $followupTime ,
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
            'message' => 'Successfully store new follow up time:'.$followupTime,
        ]);

        // $request->validate([
        //     'todo_date' => 'required', 'date',
        //     'contact_id' => 'required', 'int',
        //     'user_id' => 'required', 'int',
        //     'task_id' => 'required', 'int',
        // ], [
        //     'todo_date.required' => 'The date is required',
        //     'task_id.required' => 'The task is required.'
        // ]);

        // $todo = ToDo::create([
        //     'priority_id' => $request->priority_id,
        //     'todo_date' => $request->todo_date,
        //     'todo_deadline' => $request->todo_deadline ?? '2000-01-01',
        //     'contact_id' => $request->contact_id,
        //     'user_id' => $request->user_id,
        //     'task_id' => $request->task_id,
        //     'status_id' => $request->status_id,
        //     'type_id' => $request->type_id,
        //     'todo_remark' => $request->todo_remark ?? "None",
        //     'color_id' => $request->color_id ?? '1',
        //     'source_id' => $request->source_id
        // ]);

        // return response()->json([
        //     'data' => $todo,
        //     'status' => true,
        //     'message' => 'Successfully store employee',
        // ]);
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
}
