<?php

namespace App\Http\Controllers\Api\Billboard;

use App\Http\Controllers\Controller;
use App\Models\Billboard\BillboardTenure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BillboardTenureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'bboard_id' => 'required', 'int',
            'user_id' => 'required', 'int',
            'contact_id' => 'required', 'int',
            'tenure_startdate' => 'required', 'date',
            'tenure_enddate' => 'required | date | after:tenure_startdate',
        ], [
            'user_id.required' => 'Please select contact',
            'contact_id.required' => 'Please select user',
            'tenure_startdate.required' => 'The start date is required.',
            'tenure_enddate.required' => 'The end date is required.',
        ]);

        $tenure = BillboardTenure::create([
            'bboard_id' => $request->bboard_id,
            'user_id' => $request->user_id,
            'contact_id' => $request->contact_id,
            'tenure_startdate' => Carbon::parse($request->tenure_startdate)->toDate(),
            'tenure_enddate' => Carbon::parse($request->tenure_enddate)->toDate(),
        ]);

        return response()->json([
            'data' => $tenure,
            'status' => true,
            'message' => 'Successfully store new tenure',
        ]);
    }

    public function delete(BillboardTenure $tenure)
    {
        $tenure->delete();
        return response()->json('Tenure deleted.');
    }
}
