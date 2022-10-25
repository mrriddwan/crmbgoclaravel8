<?php

namespace App\Http\Controllers\Api\Contact;

use Illuminate\Routing\Controller;
use App\Http\Resources\Contact\ContactTypeResource;
use App\Models\Contact\ContactType;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
    public function index()
    {
        return ContactTypeResource::collection(ContactType::all()->sortBy('name'));
    }

    public function info(ContactType $type)
    {
        $type = ContactType::select(
            'id',
            'name'
        )
            ->where('id', $type->id)
            ->get();

        $data = $type->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }
}
