<?php

namespace App\Http\Controllers\Api\FollowUp;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToDo\FollowUpRequest;
use App\Http\Resources\FollowUp\FollowUpResource;
use App\Models\FollowUp\FollowUp;
use App\Models\ToDo;
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
                $query->whereDate('follow_ups.followup_created', ('='), ($selectedDate));
            })
            ->when($selectedMonth, function ($query) use ($selectedMonth) {
                $query->whereMonth('follow_ups.followup_created', ('='), ($selectedMonth));
            })
            ->when($selectedYear, function ($query) use ($selectedYear) {
                $query->whereYear('follow_ups.followup_created', ('='), ($selectedYear));
            })
            ->when($selectedDateStart && $selectedDateEnd, function ($query) use ($selectedDateStart, $selectedDateEnd) {
                $query->whereBetween('follow_ups.followup_created', [$selectedDateStart, $selectedDateEnd]);
            })

            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->paginate($paginate);

        return FollowUpResource::collection($followup);
    }
    // whereDate('created_at', '=', date('Y-m-d'))

    public function store(FollowUpRequest $request)
    {
        $followup = FollowUp::create($request->validated());

        return response()->json([
            'data' => $followup,
            'status' => true,
            'message' => 'Successfully store new follow up',
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
}