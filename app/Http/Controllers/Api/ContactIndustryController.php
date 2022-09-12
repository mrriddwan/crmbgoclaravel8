<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\ContactIndustryResource;
use App\Models\ContactIndustry;
use Illuminate\Http\Request;

class ContactIndustryController extends Controller
{
    public function index()
    {
        return ContactIndustryResource::collection(ContactIndustry::all());
    }
    
}
