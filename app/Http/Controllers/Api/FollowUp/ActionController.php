<?php

namespace App\Http\Controllers\Api\FollowUp;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowUp\ActionResource;
use Illuminate\Http\Request;
use App\Models\FollowUp\Action;

class ActionController extends Controller
{
    public function index()
    {
        return ActionResource::collection(Action::all()->sortBy('name'));
    }
}
