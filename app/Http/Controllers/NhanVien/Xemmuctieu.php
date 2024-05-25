<?php

namespace App\Http\Controllers\NhanVien;

use App\Models\Goal;
use App\Models\GoalType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class Xemmuctieu extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Mục tiêu của công ty";
        $goals = Goal::get();
        $goal_types = GoalType::get();
        return view('NhanVien.goal-tracking',compact(
            'title','goals','goal_types'
        ));
    }
}