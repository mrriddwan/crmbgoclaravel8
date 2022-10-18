<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\UserCategoryBenchmark;
use Illuminate\Http\Request;

class UserCategoryBenchmarkController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'user_cat_id' => ['required', 'int'],
            'action_id' => ['required', 'int'],
            'action_target' => ['required', 'int'],
        ], [
            'action_id.required' => 'Please select an action.',
            'action_target.required' => 'Please set a target.',
        ]);

        $benchmark = UserCategoryBenchmark::create([
            'user_cat_id' => $request->user_cat_id,
            'action_id' => $request->action_id,
            'action_target' => $request->action_target,
        ]);

        return response()->json([
            'data' => $benchmark,
            'status' => true,
            'message' => 'Successfully store user',
        ]);
    }

    public function delete(UserCategoryBenchmark $benchmark)
    {
        $benchmark->delete();
        return response()->json('Benchmark target deleted.');
    }

    public function info($id)
    {
        $benchmark = UserCategoryBenchmark::select(
            'user_categories.name as category',
            'user_category_benchmarks.id',
            'user_category_benchmarks.user_cat_id',
            'user_category_benchmarks.action_id',
            'user_category_benchmarks.action_target',
            'actions.name as action',         
            )
            ->where('user_cat_id', $id)
            ->join('user_categories', 'user_category_benchmarks.user_cat_id', '=', 'user_categories.id')
            ->join('actions', 'user_category_benchmarks.action_id', '=', 'actions.id')
            ->get();

        return response()->json(["data" => $benchmark]);
        // return UserResource::collection(User::where('id',$id));
    }

    public function update(Request $request, UserCategoryBenchmark $benchmark)
    {

        $request->validate([
            'action_target' => ['required', 'int'],
        ], [
            'action_target.required' => 'The target is required',
        ]);

        $benchmark->update([
            'action_target' => $request->action_target,
        ]);

        return response()->json([
            'data' => $benchmark,
            'status' => true,
            'message' => 'Successfully update user category',
        ]);
    }
}
