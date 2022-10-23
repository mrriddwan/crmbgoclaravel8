<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::orderBy('name', 'asc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch permission(s) ',
            'data' => $permission,
        ]);
    }

    public function permission_create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'The name is required',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $role = Role::where('id', 2)->first();
        $role->givePermissionTo($request->name);

        return response()->json([
            'data' => $permission,
            'status' => true,
            'message' => 'Successfully create new permission',
        ]);
    }

    public function permission_update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'The name is required',
        ]);

        $permission->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'data' => $permission,
            'status' => true,
            'message' => 'Successfully create new role',
        ]);
    }

    public function permission_delete(Permission $permission)
    {
        $permission->delete();
        return response()->json('Permission deleted.');
    }

    public function info($id)
    {
        $permission = Permission::select('id', 'name', 'description')->find($id);
        return response()->json(["data" => $permission]);
    }
}
