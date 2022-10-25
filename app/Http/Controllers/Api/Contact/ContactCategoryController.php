<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\ContactCategoryResource;
use App\Models\Contact\ContactCategory;
use Illuminate\Http\Request;


class ContactCategoryController extends Controller
{
    public function index()
    {
        return ContactCategoryResource::collection(ContactCategory::all()->sortBy('name'));
        // return ContactCategory::all()->only('id', 'name');
    }

    public function info(ContactCategory $category)
    {
        $category = ContactCategory::select(
            'id',
            'name'
        )
            ->where('id', $category->id)
            ->get();

        $data = $category->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }
}
