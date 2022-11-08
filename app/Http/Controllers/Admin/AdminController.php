<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
use App\Models\Forecast\ForecastType;
use App\Models\Project\Project;
use App\Models\ToDo\Task;
use App\Models\ToDo\ToDo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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
            'message' => 'Successfully store contact',
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
            'message' => 'Successfully store contact',
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
            'message' => 'Successfully store contact',
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
            'message' => 'Successfully store contact',
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
            'message' => 'Successfully store contact',
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
            'message' => 'Successfully store contact',
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
            'message' => 'Successfully store contact',
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
            'message' => 'Successfully store contact',
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

    public function user_info($id)
    {
        $user = User::select('id', 'name', 'email')->find($id);
        return response()->json(["data" => $user]);
        // return UserResource::collection(User::where('id',$id));
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
            'password' => Hash::make($request->password),
            'email_password' => 'Unset yet'
        ]);

        $user->syncRoles('user');

        return response()->json([
            'data' => $user,
            'status' => true,
            'message' => 'Successfully store user',
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
                'user_cat_id.required' => ' is required.',
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
                'password' => Hash::make($request->password),
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
            'permission_name' => ['required', 'string'],
        ], [
            'permission_name.required' => 'Please select a permission.',
        ]);

        $user->givePermissionTo($request->permission_name);

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
        $module_type = request('module_type');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');
        $search_term = request('q', '');

        //if module contact
        if ($module_type === 'contact') {
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

        else if ($module_type === 'todo') {

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

        else if ($module_type === 'forecast') {

            $selectedProduct = request('selectedProduct');
            $selectedForecastType = request('selectedForecastType');
            $selectedUser = request('selectedUser');
            $filterResult = request('filterResult');

            $forecast = Forecast::select([
                'forecasts.*',
                'forecast_products.name as product_name',
                'users.name as user_name',
                'contacts.name as contact_name',
                'forecast_results.name as result_name',
                'forecast_types.name as forecast_type_name',
                'contact_types.name as contact_type_name',
            ])
                ->join('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
                ->join('contacts', 'forecasts.contact_id', '=', 'contacts.id')
                ->join('users', 'forecasts.user_id', '=', 'users.id')
                ->join('forecast_types', 'forecasts.forecast_type_id', '=', 'forecast_types.id')
                ->join('contact_types', 'forecasts.contact_type_id', '=', 'contact_types.id')
                ->leftJoin('forecast_results', 'forecasts.result_id', '=', 'forecast_results.id')
                ->when($selectedForecastType, function ($query) use ($selectedForecastType) {
                    $query->where('forecasts.forecast_type_id', $selectedForecastType);
                })
                ->when($selectedProduct, function ($query) use ($selectedProduct) {
                    $query->where('forecasts.product_id', $selectedProduct);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('forecasts.user_id', $selectedUser);
                })
                ->when($filterResult, function ($query) use ($filterResult) {
                    if ($filterResult === "null") {
                        $query->whereNull('forecasts.result_id');
                    } else {
                        $query->where('forecasts.result_id', $filterResult);
                    }
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Contact retrieved',
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
}
