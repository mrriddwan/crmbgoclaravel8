<?php

namespace App\Http\Controllers\Api\ToDo;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToDo\ToDoSourceResource;
use App\Models\ToDo\ToDoSource;
use Illuminate\Http\Request;

class ToDoSourceController extends Controller
{
    public function index() {
        return ToDoSourceResource::collection(ToDoSource::all());
    }
}
