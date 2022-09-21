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
        return ContactCategoryResource::collection(ContactCategory::all());
        // return ContactCategory::all()->only('id', 'name');
    }
}
