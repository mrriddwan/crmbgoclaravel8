<?php

namespace App\Http\Controllers\Api\Forecast;


use App\Http\Controllers\Controller;
use App\Http\Requests\Forecast\ForecastRequest;
use App\Http\Resources\Forecast\ForecastResource;
use App\Models\Forecast\Forecast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class ForecastController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedProduct = request('selectedProduct');
        $selectedType = request('selectedType');

        $forecast = Forecast::select([
            'forecasts.*',
            'forecast_products.name as product_name',
            'forecast_results.name as result_name',
            'contact_types.name as type_name',
            'users.name as user_name',
            'contacts.name as contact_name',
        ])          
            ->join('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
            ->join('contact_types', 'forecasts.type_id', '=', 'contact_types.id')
            ->join('forecast_results', 'forecasts.result_id', '=', 'forecast_results.id')
            ->join('contacts', 'forecasts.contact_id', '=', 'contacts.id')
            ->join('users', 'forecasts.user_id', '=', 'users.id')
            ->when($selectedType, function ($query) use ($selectedType) {
                $query->where('forecasts.type_id', $selectedType);
            })
            ->when($selectedProduct, function ($query) use ($selectedProduct) {
                $query->where('forecasts.product_id', $selectedProduct);
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
            'user_id' => $request->user_id ?? 1, //change to current user later
            'type_id' => $request->type_id,
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
        return response()->json(["data"=> $forecast]);
    }

    public function update(Request $request, Forecast $forecast)
    {   
        $forecast->update([

            'forecast_date' => $request->forecast_date,        
            'forecast_updatedate' => $request->forecast_updatedate,
            'amount' => $request->amount,
            'forecast_result_id' => $request->forecast_result_id,            
            'user_id' => $request->user_id,
            'type_id' => $request->type_id,
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

    public function info(Forecast $forecast)
    {   
        $forecast = Forecast::with('type', 'product', 'contact', 'user', 'result')
                ->where('id', $forecast->id)
                ->get();

        $data = $forecast->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data forecast ',
            'data' => $data,
        ]);
    }
}
