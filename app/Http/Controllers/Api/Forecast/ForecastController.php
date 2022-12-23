<?php

namespace App\Http\Controllers\Api\Forecast;

use App\Exports\Forecast\ForecastSummaryExport;
use App\Exports\ForecastExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forecast\ForecastRequest;
use App\Http\Resources\Forecast\ForecastResource;
use App\Models\Admin\SvSbPivot;
use App\Models\Contact\Contact;
use App\Models\Forecast\Forecast;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ForecastController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedProduct = request('selectedProduct');
        $selectedForecastType = request('selectedForecastType');
        $selectedUser = request('selectedUser');
        $filterResult = request('filterResult');

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
            $forecast = Forecast::select([
                'forecasts.*',
                'forecast_products.name as product_name',
                'users.name as user_name',
                'contacts.name as contact_name',
                'forecast_results.name as result_name',
                'forecast_types.name as forecast_type_name',
            ])
                ->join('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
                ->join('contacts', 'forecasts.contact_id', '=', 'contacts.id')
                ->join('users', 'forecasts.user_id', '=', 'users.id')
                ->join('forecast_types', 'forecasts.forecast_type_id', '=', 'forecast_types.id')
                ->leftJoin('forecast_results', 'forecasts.result_id', '=', 'forecast_results.id')
                ->when($selectedForecastType, function ($query) use ($selectedForecastType) {
                    $query->where('forecasts.forecast_type_id', $selectedForecastType);
                })
                ->when($selectedProduct, function ($query) use ($selectedProduct) {
                    $query->where('forecasts.product_id', $selectedProduct);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('forecasts.user_id', $selectedUser);
                })
                ->when($filterResult, function ($query) use ($filterResult) {
                    if ($filterResult === "null") {
                        $query->whereNull('forecasts.result_id');
                    } else {
                        $query->where('forecasts.result_id', $filterResult);
                    }
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->distinct()
                ->paginate($paginate);

            return ForecastResource::collection($forecast);
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


            $forecast = Forecast::select([
                'forecasts.*',
                'forecast_products.name as product_name',
                'users.name as user_name',
                'contacts.name as contact_name',
                'forecast_results.name as result_name',
                'forecast_types.name as forecast_type_name',
            ])
                ->whereIn('forecasts.user_id', $final) // for view under supervisor and the subordinates
                ->join('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
                ->join('contacts', 'forecasts.contact_id', '=', 'contacts.id')
                ->join('users', 'forecasts.user_id', '=', 'users.id')
                ->join('forecast_types', 'forecasts.forecast_type_id', '=', 'forecast_types.id')
                ->leftJoin('forecast_results', 'forecasts.result_id', '=', 'forecast_results.id')
                ->when($selectedForecastType, function ($query) use ($selectedForecastType) {
                    $query->where('forecasts.forecast_type_id', $selectedForecastType);
                })
                ->when($selectedProduct, function ($query) use ($selectedProduct) {
                    $query->where('forecasts.product_id', $selectedProduct);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('forecasts.user_id', $selectedUser);
                })
                ->when($filterResult, function ($query) use ($filterResult) {
                    if ($filterResult === "null") {
                        $query->whereNull('forecasts.result_id');
                    } else {
                        $query->where('forecasts.result_id', $filterResult);
                    }
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->distinct()
                ->paginate($paginate);

            return ForecastResource::collection($forecast);
        }
    }

    public function store(ForecastRequest $request)
    {

        $forecast = Forecast::create([
            'forecast_date' => $request->forecast_date,
            'forecast_updatedate' => now(),
            'amount' => $request->amount,
            'user_id' => $request->user_id,
            'forecast_type_id' => $request->forecast_type_id,
            'contact_id' => $request->contact_id,
            'product_id' => $request->product_id,
            'contact_type_id' => $request->contact_type_id,
            'contact_status_id' => $request->contact_status_id,
        ]);

        return response()->json([
            'data' => $forecast,
            'status' => true,
            'message' => 'Successfully store forecast',
        ]);
    }
    public function show($id)
    {
        $forecast = Forecast::find($id);
        return response()->json(["data" => $forecast]);
    }

    public function update(Request $request, Forecast $forecast)
    {

        $request->validate([
            'forecast_date' => ['required'],
            'amount' => ['required', 'int'],
            'user_id' => ['required', 'int'],
            'forecast_type_id' => ['required', 'int'],
            'contact_id' => ['required', 'int'],
            'product_id' => ['required', 'int'],

        ], [
            'forecast_date.required' => 'The forecast date is required',
            'amount.required' => 'The amount is required.',
            'user_id.required' => 'Please select a user',
            'forecast_type_id.required' => 'Please select a type',
            'contact_id.required' => 'Please select a company',
            'product_id.required' => 'Please select a product',
 
        ]);

        $forecast->update([

            'forecast_date' => $request->forecast_date,
            'forecast_updatedate' => now(),
            'amount' => $request->amount,
            'user_id' => $request->user_id,
            'forecast_type_id' => $request->forecast_type_id,
            'contact_id' => $request->contact_id,
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data forecast ' . $forecast->name,
            'data' => $forecast,
        ]);
    }

    public function delete(Forecast $forecast)
    {
        $forecast->delete();
        return response()->json('forecast deleted.');
    }

    public function resultSelected(Request $request, Forecast $forecast)
    {
        $forecast->update([
            'result_id' => $request->result_id,
            'forecast_updatedate' => $request->forecast_updatedate,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Successfully update data To Do ' . $forecast->id,
            'data' => $forecast,
        ]);
    }

    public function info(Forecast $forecast)
    {
        $forecast = Forecast::with('forecast_type', 'product', 'contact', 'user', 'result', 'contact_type',)
            ->where('id', $forecast->id)
            ->get();

        $data = $forecast->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data forecast ',
            'data' => $data,
        ]);
    }

    public function export($forecast)
    {
        $date = Carbon::now()->format('Ymd');

        $forecastsArray = explode(',', $forecast);

        return Excel::download(new ForecastExport($forecastsArray), ('Forecasts - ' . $date . '.xlsx'));
    }

    public function exportSummary()
    {
        $date = Carbon::now()->format('Ymd');

        // $forecastsArray = explode(',', $forecast);

        return Excel::download(new ForecastSummaryExport, ('ForecastSummary - ' . $date . '.xlsx'));
    }

    public function selectAll()
    {
        return Forecast::pluck('id');
    }

    public function summary()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedtContact = request('selectedtContact');
        $selectedContactStatus = request('selectedContactStatus');
        $selectedContactType = request('selectedContactType');
        $selectedForecastType = request('selectedForecastType');
        $selectedForecastProduct = request('selectedForecastProduct');
        $selectedUser = request('selectedUser');
        $selectedYear = request('selectedYear');
        $filterResult = request('filterResult');

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
            $forecast = Forecast::select(
                'forecasts.created_at',
                'forecasts.id',
                'forecasts.contact_id',
                'forecasts.forecast_date',
                'forecasts.amount',
                'contacts.name as contact',
                'contact_statuses.name as contact_status',
                'contact_types.name as contact_type',
                'users.name as user_name',
                'forecast_types.name as forecast_type',
                'forecast_products.name as forecast_product',
                'forecast_results.name as forecast_result',
                DB::raw("DATE_FORMAT(forecasts.forecast_date, '%M-%Y') as month"),
            )
                ->leftJoin('contacts', 'forecasts.contact_id', '=', 'contacts.id')
                ->leftJoin('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->leftJoin('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                ->leftJoin('forecast_types', 'forecasts.forecast_type_id', '=', 'forecast_types.id')
                ->leftJoin('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
                ->leftJoin('forecast_results', 'forecasts.result_id', '=', 'forecast_results.id')
                ->leftJoin('users', 'forecasts.user_id', '=', 'users.id')
                ->when($selectedContactStatus, function ($query) use ($selectedContactStatus) {
                    $query->where('contact_status_id', $selectedContactStatus);
                })
                ->when($selectedForecastProduct, function ($query) use ($selectedForecastProduct) {
                    $query->where('product_id', $selectedForecastProduct);
                })
                ->when($selectedForecastType, function ($query) use ($selectedForecastType) {
                    $query->where('forecast_type_id', $selectedForecastType);
                })
                ->when($selectedContactType, function ($query) use ($selectedContactType) {
                    $query->where('contact_type_id', $selectedContactType);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('forecasts.user_id', $selectedUser);
                })
                ->when($selectedtContact, function ($query) use ($selectedtContact) {
                    $query->where('contact_id', $selectedtContact);
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereHas('forecast_summary', function ($q) use ($selectedYear) {
                        $q->whereYear('forecast_date', $selectedYear);
                    });
                })
                ->when($filterResult, function ($query) use ($filterResult) {
                    if ($filterResult === "null") {
                        $query->whereNull('forecasts.result_id');
                    } else {
                        $query->where('forecasts.result_id', $filterResult);
                    }
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate(5000);
            return $forecast->toArray();
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


            $forecast = Forecast::select(
                'forecasts.created_at',
                'forecasts.id',
                'forecasts.contact_id',
                'forecasts.forecast_date',
                'forecasts.amount',
                'contacts.name as contact',
                'contact_statuses.name as contact_status',
                'contact_types.name as contact_type',
                'users.name as user_name',
                'forecast_types.name as forecast_type',
                'forecast_products.name as forecast_product',
                'forecast_results.name as forecast_result',
                DB::raw("DATE_FORMAT(forecasts.forecast_date, '%M-%Y') as month"),
                // DB::raw("MAX(forecasts.forecast_date, '%M %Y') as last"),
            )
                ->whereIn('forecasts.user_id', $final) // for view under supervisor and the subordinates
                ->leftJoin('contacts', 'forecasts.contact_id', '=', 'contacts.id')
                ->leftJoin('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->leftJoin('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                ->leftJoin('forecast_types', 'forecasts.forecast_type_id', '=', 'forecast_types.id')
                ->leftJoin('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
                ->leftJoin('users', 'forecasts.user_id', '=', 'users.id')
                ->leftJoin('forecast_results', 'forecasts.result_id', '=', 'forecast_results.id')
                ->when($selectedContactStatus, function ($query) use ($selectedContactStatus) {
                    $query->where('contact_status_id', $selectedContactStatus);
                })
                ->when($selectedForecastProduct, function ($query) use ($selectedForecastProduct) {
                    $query->where('product_id', $selectedForecastProduct);
                })
                ->when($selectedForecastType, function ($query) use ($selectedForecastType) {
                    $query->where('forecast_type_id', $selectedForecastType);
                })
                ->when($selectedContactType, function ($query) use ($selectedContactType) {
                    $query->where('contact_type_id', $selectedContactType);
                })
                ->when($selectedUser, function ($query) use ($selectedUser) {
                    $query->where('forecasts.user_id', $selectedUser);
                })
                ->when($selectedtContact, function ($query) use ($selectedtContact) {
                    $query->where('contact_id', $selectedtContact);
                })
                ->when($selectedYear, function ($query) use ($selectedYear) {
                    $query->whereHas('forecast_summary', function ($q) use ($selectedYear) {
                        $q->whereYear('forecast_date', $selectedYear);
                    });
                })
                ->when($filterResult, function ($query) use ($filterResult) {
                    if ($filterResult === "null") {
                        $query->whereNull('forecasts.result_id');
                    } else {
                        $query->where('forecasts.result_id', $filterResult);
                    }
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))
                ->paginate(5000)
                // ->groupBy('contact_name')
                // ->groupBy('month')
                // ->toArray()
            ;

            return $forecast->toArray();
        }
    }


}
