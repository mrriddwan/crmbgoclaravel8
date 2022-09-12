<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactInchargeRequest;
use Illuminate\Http\Request;
use App\Models\ContactIncharge;
use App\Http\Resources\ContactInchargeResource;
use App\Models\Contact;

class ContactInchargeController extends Controller
{
    public function index()
    {
        $incharge = (ContactIncharge::with('contact'))->get();

        return ContactInchargeResource::collection($incharge);
    }

    public function store(ContactInchargeRequest $request)
    {
        $incharge = ContactIncharge::create(
            $request->validated()
        );

        return new ContactInchargeResource($incharge);
    }

    public function show($id)
    {
        $incharge = ContactIncharge::find($id);
        return response()->json($incharge);
    }

    public function update(ContactInchargeRequest $request, ContactIncharge $incharge)
    {
        $incharge->update([
            'contact_id' => $request->contact_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone_mobile' => $request->phone_mobile,
            'phone_mobile' => $request->phone_office,
        ]);


        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ' . $incharge->name,
            'data' => $incharge,
        ]);
    }

    public function delete(ContactIncharge $incharge)
    {
        $incharge->delete();
        return response()->json('Contact PIC deleted.');
    }

    public function info(ContactIncharge $incharge, Contact $contact)
    {   
        // $contact = ContactIncharge::with('contact')
        //         ->where('id', $contact->id)
        //         ->get();
        
        $incharge = ContactIncharge::with('contact')
                ->where('id', $incharge->contact_id)
                ->get();

        $data = $incharge->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data PIC ',
            'data' => $data,
        ]);
    }
}
