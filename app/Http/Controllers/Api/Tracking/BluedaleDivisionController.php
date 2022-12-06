<?php

namespace App\Http\Controllers\Api\Tracking;

use App\Http\Controllers\Controller;
use App\Models\Tracking\BluedaleDivision;
use Illuminate\Http\Request;

class BluedaleDivisionController extends Controller
{
    public function index()
    {
        $division =  BluedaleDivision::select('id', 'name')->orderBy('name')->get();

        return response()->json(['data' => $division]);
        // return ContactCategory::all()->only('id', 'name');
    }
}
