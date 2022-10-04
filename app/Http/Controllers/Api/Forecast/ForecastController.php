<?php

namespace App\Http\Controllers\Api\Forecast;

use App\Exports\ForecastExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forecast\ForecastRequest;
use App\Http\Resources\Forecast\ForecastResource;
use App\Models\Forecast\Forecast;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
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
        // return ForecastResource::collection(Forecast::all());
    }

    // public function list (){
    //     $forecast = Forecast::select('id', 'name')->orderBy('name')->get();

    //     return response()->json([
    //         'data' => $forecast,
    //         'status' => true,
    //         'message' => 'Successfully retrieve list of forecasts',
    //     ]);
    // }

    public function store(ForecastRequest $request)
    {

        $forecast = Forecast::create([
            'forecast_date' => $request->forecast_date,
            'forecast_updatedate' => now(),
            'amount' => $request->amount,
            'user_id' => $request->user_id ?? 2, //change to current user later
            'forecast_type_id' => $request->forecast_type_id,
            'contact_id' => $request->contact_id,
            'product_id' => $request->product_id,
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

    public function update(ForecastRequest $request, Forecast $forecast)
    {
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

    public function selectAll()
    {
        return Forecast::pluck('id');
    }
}
