<?php

namespace App\Http\Controllers\Api\Billboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Billboard\BillboardResource;
use App\Models\Billboard\Billboard;
use App\Models\Billboard\BillboardTenure;
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
        $selectedYear = request('selectedYear');


        $billboard = Billboard::with('summary')
            ->select('id', 'site_id', 'bboard_location', 'bboard_size')
            // ->when($selectedYear, function ($query) use ($selectedYear) {
            //     $query->whereHas('summary', function ($q) use ($selectedYear) {
            //         $q->whereYear('tenure_startdate', $selectedYear)
            //             ->orWhere(function ($query) use ($selectedYear) {
            //                 $query->whereYear('tenure_enddate', '=', $selectedYear);
            //             });
            //     });
            // })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->paginate(1000);

        // return BillboardResource::collection($billboard);
        return $billboard;
    }

    public function store(Request $request)
    {

        $request->validate([
            'site_id1' => 'required', 'string',
            'site_id2' => 'required', 'string',
            'bboard_location' => 'required', 'string',
            'bboard_size1' => 'required', 'string',
            'bboard_size2' => 'required', 'string',

        ], [
            'site_id1.required' => 'The site no. is required',
            'site_id2.required' => 'The site no. is required',
            'bboard_location.required' => 'The location is required.',
            'bboard_size1.required' => 'The first dimension is required.',
            'bboard_size2.required' => 'The second dimension is required.',
        ]);

        $billboard = Billboard::create([
            'site_id' => $request->site_id1 . ' - ' . $request->site_id2,
            'bboard_location' => $request->bboard_location,
            'bboard_size' => $request->bboard_size1 . ' x ' . $request->bboard_size2,
        ]);

        return response()->json([
            'data' => $billboard,
            'status' => true,
            'message' => 'Successfully store billboard',
        ]);
    }

    public function update(Request $request, Billboard $billboard)
    {

        $request->validate([
            'site_id' => 'required', 'string',
            // 'site_id1' => 'required', 'string',
            // 'site_id2' => 'required', 'string',
            'bboard_location' => 'required', 'string',
            // 'bboard_size1' => 'required', 'string',
            // 'bboard_size2' => 'required', 'string',
            'bboard_size' => 'required', 'string',

        ], [
            // 'site_id1.required' => 'The site no. is required',
            // 'site_id2.required' => 'The site no. is required',
            'site_id.required' => 'The site no. is required',
            'bboard_location.required' => 'The location is required.',
            'bboard_size.required' => 'The second dimension is required.',
            // 'bboard_size1.required' => 'The first dimension is required.',
            // 'bboard_size2.required' => 'The second dimension is required.',
        ]);

        $billboard->update([

            'site_id' => ($request->site_id1 && $request->site_id2) ?
                $request->site_id1 . ' - ' . $request->site_id2 :
                $request->site_id,
            'bboard_location' => $request->bboard_location,
            'bboard_size' => ($request->bboard_size1 && $request->bboard_size2) ?
                $request->bboard_size1 . ' x ' . $request->bboard_size2 :
                $request->bboard_size,

        ]);

        return response()->json([
            'data' => $billboard,
            'status' => true,
            'message' => 'Successfully update billboard',
        ]);
    }

    public function delete(Billboard $billboard)
    {
        $billboard->delete();
        return response()->json('Billboard deleted.');
    }

    public function info(Billboard $billboard)
    {
        $billboard = Billboard::with(
            'tenure'
        )
            ->where('id', $billboard->id)
            ->get();

        // $data = $billboard->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data billboard ',
            'data' => $billboard,
        ]);
    }

    public function tenure()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedSite = request('selectedSite');
        $selectedSize = request('selectedSize');
        $selectedYear = request('selectedYear');


        $tenure = BillboardTenure::select([
            'billboard_tenures.id',
            "billboard_tenures.tenure_startdate",
            "billboard_tenures.tenure_enddate",

            'billboards.id as billboard_id',
            'billboards.site_id',
            'billboards.bboard_location',
            'billboards.bboard_size',
            'contacts.id as company_id',
            'contacts.name as company_name'
        ])
            ->leftJoin('billboards', 'billboard_tenures.bboard_id', '=', 'billboards.id')
            ->leftJoin('contacts', 'billboard_tenures.contact_id', '=', 'contacts.id')
            //     ->when($selectedSite, function ($query) use ($selectedSite) {
            //         $query->where('billboards.site_id', $selectedSite);
            //     })
            //     ->when($selectedSize, function ($query) use ($selectedSize) {
            //         $query->where('billboards.bboard_size', $selectedSize);
            //     })
            ->when($selectedYear, function ($query) use ($selectedYear) {
                $query->whereYear('tenure_startdate', $selectedYear);
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->paginate($paginate);

        return BillboardResource::collection($tenure);
    }
}
