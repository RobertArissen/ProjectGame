<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClassModel;
use App\User;
use App\UsersBuildings;
use App\Building;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClassModel::orderBy('name')->get();
    }

    public function getUsers(Request $request)
    {
        return User::where('class_id', '=', $request->classId)->select('email', 'name')->get();
    }

    public function getLeaderBoard(Request $request)
    {
        $users =  User::where('class_id', '=', $request->classId)->select('email', 'name', 'id', 'soldiers')->get();

        foreach($users as $user){
             /* soldiers */
            $totalSoldiers = 0;
            $buildings = UsersBuildings::where('users_id', '=', $user->id)->get();
        
            foreach($buildings as $item){
                $building = Building::where('id', '=', $item->building_id)->first();
                $totalSoldiers += $building->soldiers;
            }

            $user->soldiers += $totalSoldiers;
        }

        return $users;
    }
}
