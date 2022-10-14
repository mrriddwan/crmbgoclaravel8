<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\UserCategory;
use Illuminate\Http\Request;

class UserCategoryController extends Controller
{
    public function index()
    {
        $user_category = UserCategory::select('id', 'name', 'description')->get();

        return response()->json(["data" => $user_category]);
        // return ContactCategory::all()->only('id', 'name');
    }

    public function info($id)
    {
        $user_category = UserCategory::select('id', 'name')->where('id', $id)->get();
        return response()->json(["data" => $user_category]);
        // return UserResource::collection(User::where('id',$id));
    }

    public function user_list(UserCategory $user_category)
    {
        $user_category = UserCategory::with([
            'user' => function ($q) {
                $q->select('id', 'name', 'user_cat_id');
            }
        ])
            ->select('id', 'name')
            ->get();

        $data = $user_category->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }
}
