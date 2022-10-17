<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\UserCategory;
use App\Models\Admin\UserCategoryBenchmark;
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

    public function benchmark()
    {
        $benchmark = UserCategory::with(
            [
                'benchmark'
                => function ($q) {
                    $q->select('id', 'user_cat_id', 'task_id', 'task_target');
                },
                'benchmark.task'
                => function ($q) {
                    $q->select('id', 'name');
                },
            ],
        )
            ->select(
                'user_categories.id',
                'user_categories.name as cat_name',
            )
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $benchmark,
        ]);
    }


    public function create(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The user category name is required',
        ]);

        $user_category = UserCategory::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'data' => $user_category,
            'status' => true,
            'message' => 'Successfully store user',
        ]);

    }

    public function update(Request $request, UserCategory $category)
    {

        $request->validate([
            'name' => ['required', 'string'],
        ], [
            'name.required' => 'The name is required',
        ]);

        $category->update([
            'name' => $request->name,
        ]);



        return response()->json([
            'data' => $category,
            'status' => true,
            'message' => 'Successfully update user category',
        ]);
    }

    public function delete(UserCategory $category)
    {
        $category->delete();
        return response()->json('User category deleted.');
    }
}
