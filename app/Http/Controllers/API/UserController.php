<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Building;
use App\ClassModel;
use App\UsersBuildings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::FindOrFail($request->user()->id);
        $user->class;

        /* soldiers */
        $totalSoldiers = 0;
        $buildings = UsersBuildings::where('users_id', '=', $request->user()->id)->get();
       
        foreach($buildings as $item){
            $building = Building::where('id', '=', $item->building_id)->first();
            $totalSoldiers += $building->soldiers;
        }

        $user->soldiers += $totalSoldiers;

        return $user;
    }

    public function buildings(Request $request)
    {
       $buildings = UsersBuildings::where('users_id', '=', $request->user()->id)->get();
       
       foreach($buildings as $building){
           $building->building;
       }

       return $buildings;
    }

    public function buyBuilding(Request $request)
    {
        $user = User::FindOrFail($request->user()->id);
        $building = Building::where('index', '=', $request->buildingId)->first();

        if($building->price > $user->coins) return response()->json(['success' => false, 'error' => 'Je hebt te weinig munten voor dit gebouw', ]);

        // Update user coins 
        $user->coins = $user->coins - $building->price;
        $user->save();

        // Add building to user
        UsersBuildings::create([
            'users_id' => $user->id,
            'periods_id' => $user->class->periods_id,
            'building_id' => $building->id,
            'x' => $request->Xi,
            'y' => $request->Yi,
        ]);
        
        return response()->json([
            'success' => true
        ]);

    }


}
