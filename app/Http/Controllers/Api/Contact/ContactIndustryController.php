<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;

use App\Http\Resources\Contact\ContactIndustryResource;
use App\Models\Contact\ContactIndustry;
use Illuminate\Http\Request;

class ContactIndustryController extends Controller
{
    public function index()
    {
        return ContactIndustryResource::collection(ContactIndustry::all()->sortBy('name'));
    }
    
}
