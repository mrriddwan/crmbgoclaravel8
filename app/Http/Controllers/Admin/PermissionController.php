<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::all();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch permission(s) ',
            'data' => $permission,
        ]);
    }

    public function info($id)
    {
        $permission = Permission::select('id', 'name', 'description')->find($id);
        return response()->json(["data" => $permission]);
    }
}
