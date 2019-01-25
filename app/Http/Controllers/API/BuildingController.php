<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Building;
use App\BuildingImages;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $periodsId = $request->user()->class->periods_id;
        return Building::where('periods_id', '=', $periodsId)->get();
    }

    public function all(Request $request){
        return BuildingImages::all();
    }
}
