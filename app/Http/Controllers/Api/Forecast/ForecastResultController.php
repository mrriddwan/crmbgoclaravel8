<?php

namespace App\Http\Controllers\Api\Forecast;

use App\Http\Controllers\Controller;
use App\Http\Resources\Forecast\ForecastResultResource;
use App\Models\Forecast\ForecastResult;
use Illuminate\Http\Request;

class ForecastResultController extends Controller
{
    public function index()
    {
        return ForecastResultResource::collection(ForecastResult::all());
        // return ContactCategory::all()->only('id', 'name');
    }
}
