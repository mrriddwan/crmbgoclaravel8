<?php

namespace App\Http\Controllers\Api\Billboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Billboard\TempboardResource;
use App\Models\Billboard\Tempboard;
use Illuminate\Http\Request;

class TempboardController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedSite = request('selectedSite');
        $selectedSize = request('selectedSize');


        $tempboard = Tempboard::with([
            'contact' => function ($q) {
                $q->select([
                    'id',
                    'name'
                ]);
            },
            'user' => function ($q) {
                $q->select([
                    'id',
                    'name'
                ]);
            },
        ])
            ->select([
                'tempboards.id',
                'tempboards.tpboard_entrydate',
                'tempboards.contact_id',
                'tempboards.user_id',
                'tempboards.tpboard_startdate',
                'tempboards.tpboard_enddate',
                'tempboards.tpboard_size',
                'tempboards.tpboard_location',
                'tempboards.tpboard_unit',
                'tempboards.tpboard_collection',
                'tempboards.tpboard_material',
                'tempboards.tpboard_printing',
                'tempboards.tpboard_installation',
                'tempboards.tpboard_remark',
                // 'users.id',
                // 'users.name',
                // 'contacts.id',
                // 'contacts.name',
            ])
            ->join('users', 'tempboards.user_id', '=', 'users.id')
            ->join('contacts', 'tempboards.contact_id', '=', 'contacts.id')
            ->get();
        //     ->when($selectedSite, function ($query) use ($selectedSite) {
        //         $query->where('billboards.site_id', $selectedSite);
        //     })
        //     ->when($selectedSize, function ($query) use ($selectedSize) {
        //         $query->where('billboards.bboard_size', $selectedSize);
        //     })
        //     // ->orderBy($sort_field, $sort_direction)
        //     ->search(trim($search_term))
        //     ->paginate($paginate);

        return TempboardResource::collection($tempboard);
        // return $tempboard;
    }
}
