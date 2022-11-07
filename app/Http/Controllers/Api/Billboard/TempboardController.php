<?php

namespace App\Http\Controllers\Api\Billboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Billboard\TempboardResource;
use App\Models\Admin\SvSbPivot;
use App\Models\Billboard\Tempboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TempboardController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedUser = request('selectedUser');
        $selectedYear = request('selectedYear');

        $id = Auth::id();

        if (
            (DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 2)
                ->exists()) ||
            (DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 1)
                ->exists())
        ) {
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

                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('tempboards.user_id', $selectedUser);
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereYear('tempboards.tpboard_entrydate', $selectedYear);
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereYear('tempboards.tpboard_startdate', $selectedYear);
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereYear('tempboards.tpboard_enddate', $selectedYear);
                })
                //     ->when($selectedSize, function ($query) use ($selectedSize) {
                //         $query->where('billboards.bboard_size', $selectedSize);
                //     })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                //     ->paginate($paginate);
                ->get();

            return TempboardResource::collection($tempboard);
        } else {
            $sv_sb = "";
            $final = [$id];

            if (SvSbPivot::where('supervisor_id', '=', $id)->exists()) {
                $sv_sb = SvSbPivot::select('subordinate_id')
                    ->where('supervisor_id', '=', $id)
                    ->pluck('subordinate_id');
            } else {
                $sv_sb = ["null"];
            }

            array_push($final, ...$sv_sb);

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
                ->whereIn('tempboards.user_id', $final) // for view under supervisor and the subordinates

                ->join('users', 'tempboards.user_id', '=', 'users.id')
                ->join('contacts', 'tempboards.contact_id', '=', 'contacts.id')

                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('tempboards.user_id', $selectedUser);
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereYear('tempboards.tpboard_entrydate', $selectedYear);
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereYear('tempboards.tpboard_startdate', $selectedYear);
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereYear('tempboards.tpboard_enddate', $selectedYear);
                })
                //     ->when($selectedSize, function ($query) use ($selectedSize) {
                //         $query->where('billboards.bboard_size', $selectedSize);
                //     })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                //     ->paginate($paginate);
                ->get();

            return TempboardResource::collection($tempboard);
        }

        // return $tempboard;
    }

    public function store(Request $request)
    {

        $request->validate([
            'tpboard_entrydate' => 'required', 'string',
            'contact_id' => 'required', 'int',
            'user_id' => 'required', 'int',
            'tpboard_startdate' => 'required', 'date',
            'tpboard_enddate' => 'required | date | after:tpboard_startdate',
            'tpboard_size1' => 'required', 'string',
            'tpboard_size2' => 'required', 'string',
            'tpboard_location' => 'required', 'string',
            'tpboard_unit' => 'required', 'string',
            'tpboard_collection' => 'required', 'string',
            'tpboard_material' => 'required', 'string',
            'tpboard_printing' => 'required', 'string',
            'tpboard_installation' => 'required', 'string',
            'tpboard_remark' => 'nullable', 'string',

        ], [
            'tpboard_entrydate.required' => 'The entry date is required',
            'contact_id.required' => 'Please select a contact',
            'user_id.required' => 'Please select a CS',
            'tpboard_startdate.required' => 'The start date is required',
            'tpboard_enddate.required' => 'The end date is required.',
            'tpboard_location.required' => 'The location is required.',
            'tpboard_unit.required' => 'The unit is required.',
            'tpboard_collection.required' => 'The collection is required.',
            'tpboard_material.required' => 'The material is required.',
            'tpboard_printing.required' => 'The printing is required.',
            'tpboard_installation.required' => 'The installation is required.',
            'tpboard_size1.required' => 'The first dimension is required.',
            'tpboard_size2.required' => 'The second dimension is required.',
        ]);

        $tempboard = Tempboard::create([
            'tpboard_entrydate' => $request->tpboard_entrydate,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'tpboard_startdate' => $request->tpboard_startdate,
            'tpboard_enddate' => $request->tpboard_enddate,
            'tpboard_location' => $request->tpboard_location,
            'tpboard_unit' => $request->tpboard_unit,
            'tpboard_collection' => $request->tpboard_collection,
            'tpboard_material' => $request->tpboard_material,
            'tpboard_printing' => $request->tpboard_printing,
            'tpboard_installation' => $request->tpboard_installation,
            'tpboard_remark' => $request->tpboard_remark,

            'tpboard_size' => $request->tpboard_size1 . ' x ' . $request->tpboard_size2,
        ]);

        return response()->json([
            'data' => $tempboard,
            'status' => true,
            'message' => 'Successfully store billboard',
        ]);
    }

    public function remark(Tempboard $tempboard)
    {
        $tempboard = Tempboard::where('id', $tempboard->id)
            ->select('tpboard_remark')
            ->get();

        $data = $tempboard->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }

    public function update(Request $request, Tempboard $tempboard)
    {

        $request->validate([
            'tpboard_entrydate' => 'required', 'string',
            'contact_id' => 'required', 'int',
            'user_id' => 'required', 'int',
            'tpboard_startdate' => 'required', 'date',
            'tpboard_enddate' => 'required | date | after:tpboard_startdate',
            'tpboard_size1' => 'nullable', 'string',
            'tpboard_size2' => 'nullable', 'string',
            'tpboard_location' => 'required', 'string',
            'tpboard_unit' => 'required', 'string',
            'tpboard_collection' => 'required', 'string',
            'tpboard_material' => 'required', 'string',
            'tpboard_printing' => 'required', 'string',
            'tpboard_installation' => 'required', 'string',
            'tpboard_remark' => 'nullable', 'string',

        ], [
            'tpboard_entrydate.required' => 'The entry date is required',
            'contact_id.required' => 'Please select a contact',
            'user_id.required' => 'Please select a CS',
            'tpboard_startdate.required' => 'The start date is required',
            'tpboard_enddate.required' => 'The end date is required.',
            'tpboard_location.required' => 'The location is required.',
            'tpboard_unit.required' => 'The unit is required.',
            'tpboard_collection.required' => 'The collection is required.',
            'tpboard_material.required' => 'The material is required.',
            'tpboard_printing.required' => 'The printing is required.',
            'tpboard_installation.required' => 'The installation is required.',
            // 'tpboard_size1.required' => 'The first dimension is required.',
            // 'tpboard_size2.required' => 'The second dimension is required.',
        ]);

        $tempboard->update([
            'tpboard_entrydate' => $request->tpboard_entrydate,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
            'tpboard_startdate' => $request->tpboard_startdate,
            'tpboard_enddate' => $request->tpboard_enddate,
            'tpboard_location' => $request->tpboard_location,
            'tpboard_unit' => $request->tpboard_unit,
            'tpboard_collection' => $request->tpboard_collection,
            'tpboard_material' => $request->tpboard_material,
            'tpboard_printing' => $request->tpboard_printing,
            'tpboard_installation' => $request->tpboard_installation,
            'tpboard_remark' => $request->tpboard_remark,

            'tpboard_size' => ($request->tpboard_size1 && $request->tpboard_size2) ? $request->tpboard_size1 . ' x ' . $request->tpboard_size2 : $request->tpboard_size,
        ]);

        return response()->json([
            'data' => $tempboard,
            'status' => true,
            'message' => 'Successfully update billboard',
        ]);
    }

    public function delete(Tempboard $tempboard)
    {
        $tempboard->delete();
        return response()->json('Tempboard deleted.');
    }

    public function info(Tempboard $tempboard)
    {
        $tempboard = Tempboard::with(
            'contact',
            'user'
        )
            ->where('id', $tempboard->id)
            ->get();

        $data = $tempboard->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data billboard ',
            'data' => $data,
        ]);
    }
}
