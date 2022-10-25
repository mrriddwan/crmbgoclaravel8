<?php

namespace App\Http\Controllers\Api\Forecast;

use App\Http\Controllers\Controller;
use App\Http\Resources\Forecast\ForecastTypeResource;
use App\Models\Forecast\ForecastType;
use Illuminate\Http\Request;

class ForecastTypeController extends Controller
{
    public function index()
    {
        return ForecastTypeResource::collection(ForecastType::all()->sortBy('name'));
    }

    public function info(ForecastType $type)
    {
        $type = ForecastType::select(
            'id',
            'name'
        )
            ->where('id', $type->id)
            ->get();

        $data = $type->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch task info ',
            'data' => $data,
        ]);
    }
}
