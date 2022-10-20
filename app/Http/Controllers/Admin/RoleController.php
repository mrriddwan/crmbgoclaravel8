<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch role(s) ',
            'data' => $role,
        ]);
    }

    public function info($id)
    {
        $role = Role::select('id', 'name', 'description')->find($id);
        return response()->json(["data" => $role]);
    }

    public function role_permissions(Role $role)
    {
        
        $role->permissions;
        return response()->json(["data" => $role]);
    }
}
