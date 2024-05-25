<?php

namespace App\Http\Controllers\Admin;

use App\Models\GoalType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoalTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Loại mục tiêu";
        $goal_types = GoalType::get();
        return view('backend.goal-type',compact(
            'title','goal_types',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'type' => 'required|max:100',
            'description' => 'nullable|max:255'
        ]);
        GoalType::create([
            'type' => $request->type,
            'description' => $request->description,
        ]);
        $notification = notify('Thêm loại mục tiêu thành công');
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'type' => 'required|max:100',
            'description' => 'nullable|max:255'
        ]);
        $goal_type = GoalType::findOrFail($request->id);
        $goal_type->update([
            'type' => $request->type,
            'description' => $request->description,
        ]);
        $notification = notify('Cập nhật loại mục tiêu thành công');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $goal_type = GoalType::findOrFail($request->id);
        $goal_type->delete();
        $notification = notify('Xóa loại mục tiêu thành công');
        return back()->with($notification);
    }
    
}
