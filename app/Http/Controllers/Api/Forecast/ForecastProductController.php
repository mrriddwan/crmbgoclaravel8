<?php

namespace App\Http\Controllers\Api\Forecast;

use App\Http\Controllers\Controller;
use App\Http\Resources\Forecast\ForecastProductResource;
use App\Models\ForecastProduct;
use Illuminate\Http\Request;

class ForecastProductController extends Controller
{
    public function index()
    {
        return ForecastProductResource::collection(ForecastProduct::all());
        // return ContactCategory::all()->only('id', 'name');
    }
}
