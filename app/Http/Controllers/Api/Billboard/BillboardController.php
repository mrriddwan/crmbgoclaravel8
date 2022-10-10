<?php

namespace App\Http\Controllers\Api\Billboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Billboard\BillboardResource;
use App\Models\Billboard\Billboard;
use Illuminate\Http\Request;

class BillboardController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedSite = request('selectedSite');
        $selectedSize = request('selectedSize');


        $billboard = Billboard::with([
            'tenure' => function ($q) {
                $q->select([
                    'id',
                    "tenure_startdate",
                    "tenure_enddate",
                    "bboard_id",
                    "contact_id"
                ]);
            }
        ])
            ->select([
                'billboards.id',
                'billboards.site_id',
                'billboards.bboard_location',
                'billboards.bboard_size',
                // 'billboard_tenures.bboard_id',
                // 'billboard_tenures.tenure_startdate',
                // 'billboard_tenures.tenure_enddate'
            ])
            // ->join('billboard_tenures', 'billboard_tenures.bboard_id', '=', 'billboards.id')
            ->get()
            // ->toArray()
            ;
        //     ->when($selectedSite, function ($query) use ($selectedSite) {
        //         $query->where('billboards.site_id', $selectedSite);
        //     })
        //     ->when($selectedSize, function ($query) use ($selectedSize) {
        //         $query->where('billboards.bboard_size', $selectedSize);
        //     })
        //     // ->orderBy($sort_field, $sort_direction)
        //     ->search(trim($search_term))
        //     ->paginate($paginate);

        return BillboardResource::collection($billboard);
        // return $billboard;
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Successfully fetch data Contact ',
        //     'data' => $billboard,
        // ]);
    }
}
