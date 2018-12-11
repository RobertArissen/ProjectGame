<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ClassModel;
use App\User;

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
}
