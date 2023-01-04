<?php

namespace App\Http\Controllers\Api\Forecast;

use App\Http\Controllers\Controller;
use App\Http\Resources\Forecast\ForecastResultResource;
use App\Models\Forecast\Forecast;
use App\Models\Forecast\ForecastResult;
use Illuminate\Http\Request;

class ForecastResultController extends Controller
{
    public function index()
    {
        return ForecastResultResource::collection(ForecastResult::all());
        // return ContactCategory::all()->only('id', 'name');
    }

    public function list()
    {

        $result = ForecastResult::whereKeyNot(100)->get();

        return response()->json([
            'data' => $result,
            'status' => true,
            'message' => 'Successfully store forecast result',
        ]);
    }

    public function info(ForecastResult $result)
    {
        $forecast_esult = ForecastResult::select(
            'id',
            'name'
        )
            ->where('id', $result->id)
            ->get();

        $data = $forecast_esult->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch forecast result info ',
            'data' => $data,
        ]);
    }
}
