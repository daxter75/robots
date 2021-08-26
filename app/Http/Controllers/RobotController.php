<?php

namespace App\Http\Controllers;

use App\Http\Resources\RobotResource;
use App\Models\Robot;
use Illuminate\Http\Request;

class RobotController extends Controller
{
    public function index()
    {
        return RobotResource::collection(Robot::all());
    }

    public function show(Robot $robot)
    {
        return new RobotResource($robot);
    }
}
