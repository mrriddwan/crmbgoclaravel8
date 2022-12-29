<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all()->whereNotIn('id', [1,2]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch role(s) ',
            'data' => $role,
        ]);
    }

    public function role_create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'The name is required',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'data' => $role,
            'status' => true,
            'message' => 'Successfully create new role',
        ]);
    }

    public function role_update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'The name is required',
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'data' => $role,
            'status' => true,
            'message' => 'Successfully updated role',
        ]);
    }

    public function role_delete(Role $role)
    {
        $role->delete();
        return response()->json('Role deleted.');
    }

    public function info($id)
    {
        $role = Role::select('id', 'name', 'description')->find($id);
        return response()->json(["data" => $role]);
    }

    public function role_permissions()
    {
        $role = Role::with([
            'permissions' => function ($q) {
                $q->select('id', 'name');
            },
        ])
            ->whereKeyNot(1)
            ->select('id', 'name', 'description')
            ->get();

        return response()->json(["data" => $role]);
    }

    public function add_permission(Role $role, Request $request)
    {
        $request->validate([
            'role_id' => ['required', 'int'],
            'permission_name' => ['required'],
        ], [
            'role_id.required' => 'The role_id is required',
            'permission_name.required' => 'Please select a permission',
        ]);

        $role->givePermissionTo($request->permission_name);

        return response()->json([
            'data' => $role,
            'status' => true,
            'message' => 'Successfully added permission into selected role',
        ]);
    }

    public function remove_permission(Role $role, Request $request)
    {



        // $role->revokePermissionTo('create todos');
        $role->revokePermissionTo($request->permission_name); 

        return response()->json([
            'data' => $role,
            'status' => true,
            'message' => 'Successfully remove permission from selected role',
        ]);
    }
}
