<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Announcement;
use App\Models\Admin\Permission;
use App\Models\Admin\SvSbPivot;
use App\Models\Contact\Contact;
use App\Models\Contact\ContactCategory;
use App\Models\Contact\ContactIndustry;
use App\Models\Contact\ContactStatus;
use App\Models\Contact\ContactType;
use App\Models\FollowUp\Action;
use App\Models\Forecast\Forecast;
use App\Models\Forecast\ForecastProduct;
use App\Models\Forecast\ForecastResult;
use App\Models\Forecast\ForecastType;
use App\Models\Project\Project;
use App\Models\ToDo\Task;
use App\Models\ToDo\TextColor;
use App\Models\ToDo\ToDo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{

    public function createContactCategory(Request $request)
    {

        $contact_category = ContactCategory::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $contact_category,
            'status' => true,
            'message' => 'Successfully create contact category',
        ]);
    }

    public function createContactStatus(Request $request)
    {

        $contact_status = ContactStatus::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $contact_status,
            'status' => true,
            'message' => 'Successfully create contact status',
        ]);
    }

    public function createContactType(Request $request)
    {

        $contact_type = ContactType::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $contact_type,
            'status' => true,
            'message' => 'Successfully create contact type',
        ]);
    }

    public function createContactIndustry(Request $request)
    {

        $contact_industry = ContactIndustry::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $contact_industry,
            'status' => true,
            'message' => 'Successfully create contact industry',
        ]);
    }

    public function createToDoTask(Request $request)
    {

        $todo_task = Task::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $todo_task,
            'status' => true,
            'message' => 'Successfully todo task',
        ]);
    }

    public function createToDoAction(Request $request)
    {

        $todo_action = Action::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $todo_action,
            'status' => true,
            'message' => 'Successfully create todo action',
        ]);
    }

    public function createTextColor(Request $request)
    {

        $text_color = TextColor::create([
            'color_code' => $request->color_code,
        ]);

        return response()->json([
            'data' => $text_color,
            'status' => true,
            'message' => 'Successfully create text color',
        ]);
    }

    public function createForecastType(Request $request)
    {

        $forecast_type = ForecastType::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $forecast_type,
            'status' => true,
            'message' => 'Successfully store new forecast type',
        ]);
    }

    public function createForecastProduct(Request $request)
    {

        $forecast_product = ForecastProduct::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $forecast_product,
            'status' => true,
            'message' => 'Successfully store new forecast product',
        ]);
    }

    public function createForecastResult(Request $request)
    {

        $forecast_result = ForecastResult::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $forecast_result,
            'status' => true,
            'message' => 'Successfully store new forecast result',
        ]);
    }

    public function updateContactCategory(Request $request, ContactCategory $category)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The contact product is required',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $category,
            'status' => true,
            'message' => 'Successfully update contact category',
        ]);
    }

    public function updateContactStatus(Request $request, ContactStatus $status)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The contact status is required',
        ]);

        $status->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $status,
            'status' => true,
            'message' => 'Successfully update contact status',
        ]);
    }

    public function updateContactType(Request $request, ContactType $type)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The contact type is required',
        ]);

        $type->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $type,
            'status' => true,
            'message' => 'Successfully update contact type',
        ]);
    }

    public function updateContactIndustry(Request $request, ContactIndustry $industry)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The contact industry is required',
        ]);

        $industry->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $industry,
            'status' => true,
            'message' => 'Successfully update contact industry',
        ]);
    }

    public function updateToDoTask(Request $request, Task $task)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The task is required',
        ]);

        $task->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $task,
            'status' => true,
            'message' => 'Successfully update task',
        ]);
    }

    public function updateToDoAction(Request $request, Action $action)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The action is required',
        ]);

        $action->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $action,
            'status' => true,
            'message' => 'Successfully update action.',
        ]);
    }

    public function updateTextColor(Request $request, TextColor $textColor)
    {

        $request->validate([
            'color_code' => ['required', 'string'],
        ], [
            'color_code.required' => 'Select a color',
        ]);

        $textColor->update([
            'color_code' => $request->color_code,
        ]);

        return response()->json([
            'data' => $textColor,
            'status' => true,
            'message' => 'Successfully update text color.',
        ]);
    }

    public function updateForecastProduct(Request $request, ForecastProduct $product)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The forecast product is required',
        ]);

        $product->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $product,
            'status' => true,
            'message' => 'Successfully update forecast product.',
        ]);
    }

    public function updateForecastType(Request $request, ForecastType $type)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The forecast type is required',
        ]);

        $type->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $type,
            'status' => true,
            'message' => 'Successfully update forecast type.',
        ]);
    }

    public function updateForecastResult(Request $request, ForecastResult $result)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The forecast result is required',
        ]);

        $result->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $result,
            'status' => true,
            'message' => 'Successfully update forecast result.',
        ]);
    }

    public function deleteContactCategory(ContactCategory $category)
    {
        $category->delete();
        return response()->json('Contact category deleted.');
    }

    public function deleteContactStatus(ContactStatus $status)
    {
        $status->delete();
        return response()->json('Contact status deleted.');
    }

    public function deleteContactType(ContactType $type)
    {
        $type->delete();
        return response()->json('Contact type deleted.');
    }

    public function deleteContactIndustry(ContactIndustry $industry)
    {
        $industry->delete();
        return response()->json('Contact industry deleted.');
    }

    public function deleteToDoTask(Task $task)
    {
        $task->delete();
        return response()->json('To do task deleted.');
    }

    public function deleteToDoAction(Action $action)
    {
        $action->delete();
        return response()->json('To do action deleted.');
    }

    public function deleteTextColor(TextColor $textColor)
    {
        $textColor->delete();
        return response()->json('Text color deleted.');
    }

    public function deleteForecastType(ForecastType $type)
    {
        $type->delete();
        return response()->json('Forecast type deleted.');
    }

    public function deleteForecastProduct(ForecastProduct $product)
    {
        $product->delete();
        return response()->json('Forecast product deleted.');
    }

    public function deleteForecastResult(ForecastResult $result)
    {
        $result->delete();
        return response()->json('Forecast result deleted.');
    }

    public function user_info($id)
    {
        $user = User::select('id', 'name', 'email')->find($id);
        return response()->json(["data" => $user]);
    }

    public function user_create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required_with:confirm_password', 'min:6'],
            'confirm_password' => ['required', 'same:password']
        ], [
            'name.required' => 'The name is required',
            'email.required' => 'The email is required.',
            'password.required' => 'The password is required',
            'confirm_password.required' => 'The confirm password is required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'email_password' => 'Unset yet'
        ]);

        $user->syncRoles('user');

        return response()->json([
            'data' => $user,
            'status' => true,
            'message' => 'Successfully create new user',
        ]);
    }

    public function user_update(Request $request, User $user)
    {
        if ($request->name) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
            ], [
                'name.required' => 'The name is required',
            ]);

            $user->update([
                'name' => $request->name,
            ]);
        } else if ($request->email) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'email_password' => ['required', 'min:6'],
            ], [
                'email.required' => 'The email is required.',
                'email_password.required' => 'The email password is required.',
            ]);

            $user->update([
                'email' => $request->email,
                'email_password' => $request->email_password,
            ]);
        } else if ($request->user_cat_id) {
            $request->validate([
                'user_cat_id' => ['required', 'int'],
            ], [
                'user_cat_id.required' => ' User category is required.',
            ]);

            $user->update([
                'user_cat_id' => $request->user_cat_id,
            ]);
        } else {
            $request->validate([
                'password' => ['required_with:confirm_password', 'min:6'],
                'confirm_password' => ['required', 'same:password']
            ], [
                'password.required' => 'The password is required',
                'confirm_password.required' => 'The confirm password is required',
            ]);

            $user->update([
                'password' => $request->password,
            ]);
        }



        return response()->json([
            'data' => $user,
            'status' => true,
            'message' => 'Successfully update user',
        ]);
    }

    public function user_cat_remove(User $user)
    {
        $user->update([
            'user_cat_id' => null,
        ]);

        return response()->json([
            'data' => $user,
            'status' => true,
            'message' => 'Successfully remove user from respective category',
        ]);
    }

    public function check_supervisor(Request $request)
    {

        $id = Auth::id(); // Retrieve the currently authenticated user's ID...


        // $userArray = [$id];

        $sv_sb = "";
        $final = [1];

        if (SvSbPivot::where('supervisor_id', '=', 1)->exists()) {
            $sv_sb = SvSbPivot::select('subordinate_id')
                ->where('supervisor_id', '=', 1)
                ->pluck('subordinate_id');
        } else {
            $sv_sb = ["null"];
        }

        array_push($final, ...$sv_sb);

        return response()->json([
            'data' => $final,
            'status' => true,
            'message' => 'This is the subordinate id(s)',
        ]);
    }

    public function user_role_permissions()
    {
        $selectedUser = request('selectedUser');

        $summary = User::with([
            'roles' => function ($q) {
                $q->select('id', 'name')
                    ->orderBy('id', 'asc');
            },
            'roles.permissions' => function ($q) {
                $q->select('id', 'name');
            },
            'permissions'
        ])
            ->whereKeyNot(1)
            ->select('users.id', 'users.name',)
            ->when($selectedUser, function ($query) use ($selectedUser) {
                $query->where('users.id', $selectedUser);
            })
            ->get();

        return response()->json([

            'status' => true,
            'message' => 'User-Role-Permissions attained',
            'data' => $summary,
        ]);
    }

    public function user_role_permissions_info($user_id)
    {
        $summary = User::with([
            'roles' => function ($q) {
                $q->select('id', 'name');
            },
            'roles.permissions' => function ($q) {
                $q->select('id', 'name');
            },
            'permissions'
        ])
            // ->join('')
            // ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.id', 'users.name',)
            ->where('users.id', $user_id)
            ->get();

        return response()->json([

            'status' => true,
            'message' => 'User-Role-Permissions attained',
            'data' => $summary,
        ]);
    }

    public function user_role_update(User $user, Request $request)
    {
        $user->syncRoles([$request->role_name]);

        return response()->json([
            'status' => true,
            'message' => 'User Role updated',
            'data' => $user,
        ]);
    }

    public function user_permission_update(User $user, Request $request)
    {
        $request->validate([
            'permission_name' => ['required'],
        ], [
            'permission_name.required' => 'Please select a permission.',
        ]);

        $user->givePermissionTo([$request->permission_name]);

        return response()->json([
            'status' => true,
            'message' => 'User permission updated',
            'data' => $user,
        ]);
    }

    public function user_permission_remove(User $user, Request $request)
    {
        $permission = Permission::findOrFail($request->permission_id);

        $user->permissions()->detach($permission);

        return response()->json([
            'status' => true,
            'message' => 'User permission removed',
            'data' => $user,
        ]);
    }

    public function module_export()
    {
        $export_type = request('export_type');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');
        $search_term = request('q', '');

        //if module contact
        if ($export_type === 'contact') {
            $selectedUser = request('selectedUser');
            $selectedStatus = request('selectedStatus');
            $selectedCategory = request('selectedCategory');
            $selectedType = request('selectedType');
            $selectedIndustry = request('selectedIndustry');


            $contact = Contact::select([
                'contacts.*',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'contact_categories.name as category_name',
                'contact_industries.name as industry_name'
            ])
                ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                ->join('contact_categories', 'contacts.category_id', '=', 'contact_categories.id')
                ->join('contact_industries', 'contacts.industry_id', '=', 'contact_industries.id')
                ->join('users', 'contacts.user_id', '=', 'users.id')
                ->with(['incharge' => function ($q) {
                    $q->select('id', 'contact_id', 'name', 'email', 'phone_mobile', 'phone_office');
                }])
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('contacts.user_id', $selectedUser);
                })
                ->when($selectedStatus, function ($query) use ($selectedStatus) {
                    $query->where('contacts.status_id', $selectedStatus);
                })
                ->when($selectedCategory, function ($query) use ($selectedCategory) {
                    $query->where('contacts.category_id', $selectedCategory);
                })
                ->when($selectedType, function ($query) use ($selectedType) {
                    $query->where('contacts.type_id', $selectedType);
                })
                ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                    $query->where('contacts.industry_id', $selectedIndustry);
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Contact retrieved',
                'data' => $contact,
            ]);
        }

        //if module todo

        else if ($export_type === 'todo') {

            $selectedSource = request('selectedSource');
            $selectedStatus = request('selectedStatus');
            // $selectedContact = request('selectedContact');
            $selectedUser = request('selectedUser');
            $selectedTask = request('selectedTask');
            $selectedType = request('selectedType');

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
                ->when($selectedStatus, function ($query) use ($selectedStatus) {
                    $query->where('to_dos.status_id', $selectedStatus);
                })
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
                // ->when($selectedDate, function ($query) use ($selectedDate) {
                //     $query->whereDate('to_dos.todo_date', ('='), ($selectedDate));
                // })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'To do retrieved',
                'data' => $todo,
            ]);
        }

        //if module forecast

        else if ($export_type === 'forecast') {


            $filter_forecast_results = request('filter_forecast_results') ? explode(',', request('filter_forecast_results')) : [];
            $filter_contact_types = request('filter_contact_types') ? explode(',', request('filter_contact_types')) : [];
            $filter_contact_statuses = request('filter_contact_statuses') ? explode(',', request('filter_contact_statuses')) : [];
            $filter_forecast_types = request('filter_forecast_types') ? explode(',', request('filter_forecast_types')) : [];
            $filter_forecast_products = request('filter_forecast_products') ? explode(',', request('filter_forecast_products')) : [];
            $filter_forecast_users = request('filter_forecast_users') ? explode(',', request('filter_forecast_users')) : [];

            $filter_forecast_startdate = request('filter_forecast_startdate');
            $filter_forecast_enddate = request('filter_forecast_enddate');
            $filter_forecast_startupdate = request('filter_forecast_startupdate');
            $filter_forecast_endupdate = request('filter_forecast_endupdate');


            $forecast = Forecast::select([
                'forecasts.created_at',
                'forecasts.id',
                'forecasts.forecast_updatedate',
                'forecasts.amount',
                'forecasts.forecast_date',
                'forecasts.result_id',
                'forecasts.user_id',
                'forecasts.contact_id',
                'forecasts.product_id',
                'forecasts.forecast_type_id',
                'forecast_products.name as forecast_product',
                'users.name as user_name',
                'contacts.name as contact_name',
                'forecast_results.name as result_name',
                'forecast_types.name as forecast_type',
                'contact_types.name as contact_type',
                'contact_statuses.name as contact_status',
                'forecasts.updated_at',
                'forecasts.created_at',
            ])
                ->join('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
                ->join('contacts', 'forecasts.contact_id', '=', 'contacts.id')
                ->join('users', 'forecasts.user_id', '=', 'users.id')
                ->join('forecast_types', 'forecasts.forecast_type_id', '=', 'forecast_types.id')
                ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->leftJoin('forecast_results', 'forecasts.result_id', '=', 'forecast_results.id')
                ->when($filter_forecast_types, function ($query) use ($filter_forecast_types) {
                    $query->whereIn('forecasts.forecast_type_id', $filter_forecast_types);
                })
                ->when($filter_forecast_products, function ($query) use ($filter_forecast_products) {
                    $query->whereIn('forecasts.product_id', $filter_forecast_products);
                })
                ->when($filter_contact_types, function ($query) use ($filter_contact_types) {
                    $query->whereIn('contacts.type_id', $filter_contact_types);
                })
                ->when($filter_contact_statuses, function ($query) use ($filter_contact_statuses) {
                    $query->whereIn('contacts.status_id', $filter_contact_statuses);
                })
                ->when($filter_forecast_users, function ($query) use ($filter_forecast_users) {
                    $query->whereIn('forecasts.user_id', $filter_forecast_users);
                })
                //if have id 100, query include whereNull
                ->when($filter_forecast_results, function ($query) use ($filter_forecast_results) {
                    if (in_array("100", $filter_forecast_results)) {
                        $query->whereIn('forecasts.result_id', $filter_forecast_results)->orWhereNull('forecasts.result_id');
                    } else {
                        $query->whereIn('forecasts.result_id', $filter_forecast_results);
                    }
                })
                ->when($filter_forecast_startdate && $filter_forecast_enddate, function ($query) use ($filter_forecast_startdate, $filter_forecast_enddate) {
                    $query->whereBetween('forecasts.forecast_date', [$filter_forecast_startdate, $filter_forecast_enddate]);
                })
                ->when($filter_forecast_startupdate && $filter_forecast_endupdate, function ($query) use ($filter_forecast_startupdate, $filter_forecast_endupdate) {
                    $query->whereBetween('forecasts.forecast_updatedate', [$filter_forecast_startupdate, $filter_forecast_endupdate]);
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Forecast retrieved',
                'data' => $forecast,
            ]);
        }

        //if module project
        else {

            $searchStartDate = request('searchStartDate');
            $searchEndDate = request('searchEndDate');
            $searchDuration = request('searchDuration');
            $searchEntryDate = request('searchEntryDate');

            $project = Project::select([
                'projects.*',
                'users.name as user_name',
                'contacts.name as contact_name',
            ])
                ->join('contacts', 'projects.contact_id', '=', 'contacts.id')
                ->join('users', 'projects.user_id', '=', 'users.id')
                // ->when($searchStartDate, function ($query) use ($searchStartDate) {
                //     $query->where('projects.project_startdate', $searchStartDate);
                // })
                // ->when($searchEndDate, function ($query) use ($searchEndDate) {
                //     $query->where('projects.project_enddate', $searchEndDate);
                // })
                // // ->when($searchDuration, function ($query) use ($searchDuration) {
                // //     $query->where('projects.project_duration', $searchDuration);
                // // })
                // ->when($searchEntryDate, function ($query) use ($searchEntryDate) {
                //     $query->where('projects.created_at', $searchEntryDate);
                // })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Project retrieved',
                'data' => $project,
            ]);
        }
    }

    public function announcement_reminder()
    {
        $announcement = Announcement::with('from_user', 'to_user')->get();

        return response()->json([
            'status' => true,
            'message' => 'All announcement/reminder retrieved',
            'data' => $announcement,
        ]);
    }

    public function message_create(Request $request)
    {
        if ($request->message_type_id === 2) {
            $request->validate([
                'message' => ['required', 'string'],
                'from_user_id' => ['required', 'integer'],
                'to_user_id' => ['required'],
                'message_type_id' => ['required', 'integer']
            ], [
                'message.required' => 'The message is required',
                'from_user_id.required' => 'The sender user is required',
                'message_type_id.required' => 'The message type is required',
                'to_user_id.required' => 'The receiver user is required',
            ]);
        } else {
            $request->validate([
                'message' => ['required', 'string'],
                'from_user_id' => ['required', 'integer'],
                'message_type_id' => ['required', 'integer'],
            ], [
                'message.required' => 'The message is required',
                'from_user_id.required' => 'The sender user is required',
                'message_type_id.required' => 'The message type is required',
            ]);
        }

        $receiver_user_id = $request->to_user_id;

        if (!$receiver_user_id) {
            Announcement::create([
                'message' => $request->message,
                'from_user_id' => $request->from_user_id,
                'message_type_id' => $request->message_type_id,
                'to_user_id' => null,
            ]);
        } else {
            foreach ($receiver_user_id as $user) {
                Announcement::create([
                    'message' => $request->message,
                    'from_user_id' => $request->from_user_id,
                    'message_type_id' => $request->message_type_id,
                    'to_user_id' => $user ?? null,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully create announcement / task',
        ]);
    }

    public function message_delete(Announcement $announcement)
    {
        $announcement->delete();
        return response()->json('Announcement/reminder deleted.');
    }

    public function announcement_reminder_info($announcement)
    {
        $info = Announcement::where('announcements.id', $announcement)
            ->get();

        return response()->json([

            'status' => true,
            'message' => 'Selected announcement/reminder retrieved',
            'data' => $info,
        ]);
    }

    public function message_update(Announcement $announcement, Request $request)
    {
        $request->validate([
            'message' => ['required', 'string'],
            'from_user_id' => ['required', 'integer'],
            'to_user_id' => ['required'],
            'message_type_id' => ['required', 'integer']
        ], [
            'message.required' => 'The message is required',
            'from_user_id.required' => 'The sender user is required',
            'message_type_id.required' => 'The message type is required',
            'to_user_id.required' => 'The receiver user is required',
        ]);

        $announcement->update([
            'message' => $request->message,
            'from_user_id' => $request->from_user_id,
            'message_type_id' => $request->message_type_id,
            'to_user_id' => $request->to_user_id ?? null,
        ]);
        return response()->json('Announcement/reminder updated.');
    }

    public function download_tutorial($tutorial_no)
    {
        // $filepath = $request->url;
        // $file_name = public_path(`$filepath`);
        // "\\storage\\tutorials\\8_admin_data.pdf" public\storage\tutorials\8_admin_data.pdf

        $path = '/storage/tutorials/';

        switch ($tutorial_no) {
            case 1:
                $path = $path . "1_create_contact.pdf";
                break;
            case 2:
                $path = $path . "2_create_todo_followup.pdf";
                break;
            case 3:
                $path = $path . "3_import_format_contact.pdf";
                break;
            case 4:
                $path = $path . "4_project.pdf";
                break;
            case 5:
                $path = $path . "5_performance.pdf";
                break;
            case 6:
                $path = $path . "6_billboard_tempboard.pdf";
                break;
            case 7:
                $path = $path . "7_tracking_general_travelguide.pdf";
                break;
            case 8:
                $path = $path . "8_admin_data.pdf";
                break;
            case 9:
                $path = $path . "9_admin_user_manage.pdf";
                break;
            case 10:
                $path = $path . "10_admin_announcement.pdf";
                break;
            case 11:
                $path = $path . "11_admin_export_import.pdf";
                break;
            case 12:
                $path = $path . "12_admin_access.pdf";
                break;
            case 13:
                $path = $path . "13_forecast.pdf";
                break;
        }


        $file_name = public_path($path);
        return Response::download($file_name);
        // storage/tutorials/
    }
}
