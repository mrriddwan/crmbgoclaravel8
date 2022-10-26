<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;
use App\Models\Admin\SvSbPivot;
use App\Models\Contact\ContactCategory;
use App\Models\Contact\ContactIndustry;
use App\Models\Contact\ContactStatus;
use App\Models\Contact\ContactType;
use App\Models\FollowUp\Action;
use App\Models\Forecast\ForecastProduct;
use App\Models\Forecast\ForecastType;
use App\Models\ToDo\Task;
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
}
