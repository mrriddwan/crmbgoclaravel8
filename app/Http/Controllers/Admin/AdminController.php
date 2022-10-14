<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
