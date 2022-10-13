<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
        // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function getuserid(Request $request)
    {
        $user = Auth::user(); // Retrieve the currently authenticated user...
        $id = Auth::id(); // Retrieve the currently authenticated user's ID...


        // $user = $request->user(); // returns an instance of the authenticated user...
        // $id = $request->user()->id; // Retrieve the currently authenticated user's ID...


        // $user = auth()->user(); // Retrieve the currently authenticated user...
        // $id = auth()->id();  // Retrieve the currently authenticated user's ID...

        // $contact = Contact::all();

        // return $contact->where('user_id','=',$id);
        // $user = auth()->user();
        dd($id);
        // dd($user);
    }
}
