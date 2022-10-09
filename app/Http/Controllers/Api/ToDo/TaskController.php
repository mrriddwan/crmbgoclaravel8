<?php

namespace App\Http\Controllers\Api\ToDo;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToDo\TaskResource;
use App\Models\ToDo\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        return TaskResource::collection(Task::all()->sortBy('name'));
    }
}
