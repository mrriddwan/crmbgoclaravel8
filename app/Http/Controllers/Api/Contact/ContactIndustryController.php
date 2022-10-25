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

    public function info(ContactIndustry $industry)
    {
        $industry = ContactIndustry::select(
            'id',
            'name'
        )
            ->where('id', $industry->id)
            ->get();

        $data = $industry->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }
    
}
