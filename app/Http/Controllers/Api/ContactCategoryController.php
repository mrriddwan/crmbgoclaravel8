<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactCategoryResource;
use App\Models\ContactCategory;
use Illuminate\Http\Request;


class ContactCategoryController extends Controller
{
    public function index()
    {
        return ContactCategoryResource::collection(ContactCategory::all());
        // return ContactCategory::all()->only('id', 'name');
    }
}
