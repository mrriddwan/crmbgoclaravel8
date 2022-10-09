<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\ContactStatusResource;
use App\Models\Contact\ContactStatus;
use Illuminate\Http\Request;

class ContactStatusController extends Controller
{
    public function index()
    {
        return ContactStatusResource::collection(ContactStatus::all()->sortBy('name'));
    }

    public function dropdown()
    {
        // $status = ContactStatusResource::collection(ContactStatus::all());

        // $data = ([
        //     'value' => $status -> id,
        //     'text' => $status -> name
        // ]);
        $status = ContactStatus::all('id', 'name');

        $data = collect($status)->map(function ($item) {
            return [
                'value' => $item['id'],
                'text' => $item['name']
        ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data status ',
            'data' => $data,
        ]);
    }

}
