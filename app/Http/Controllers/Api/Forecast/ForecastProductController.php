<?php

namespace App\Http\Controllers\Api\Forecast;

use App\Http\Controllers\Controller;
use App\Http\Resources\Forecast\ForecastProductResource;
use App\Models\Forecast\ForecastProduct;
use Illuminate\Http\Request;

class ForecastProductController extends Controller
{
    public function index()
    {
        return ForecastProductResource::collection(ForecastProduct::all()->sortBy('name'));
        // return ContactCategory::all()->only('id', 'name');
    }

    public function info(ForecastProduct $product)
    {
        $product = ForecastProduct::select(
            'id',
            'name'
        )
            ->where('id', $product->id)
            ->get();

        $data = $product->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch task info ',
            'data' => $data,
        ]);
    }
}
