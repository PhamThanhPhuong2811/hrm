<?php

namespace App\Http\Controllers\Admin;

use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HolidayRequest;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Ngày lễ";
        $holidays = Holiday::get();
        
        return view('backend.holidays',compact('title','holidays'));
    }

    public function completed(Request $request,Holiday $holiday){
    //    $holiday = Holiday::find($request->id);
       $holiday->update([
           'completed'=>1,
       ]);
       $notification = notify('Ngày lễ đã qua');
        return back()->with($notification);
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
            'name'=>'required',
            'from'=>'required',
            'to'=>'required',
        ]);
        Holiday::create([
            'name'=>$request->name,
            'from'=>$request->from,
            'to'=>$request->to,
        ]);
        $notification = notify('Thêm ngày lễ thành công');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $holiday = Holiday::find($request->id);
        $holiday->update([
            'name'=>$request->name,
            'from'=>$request->from,
            'to'=>$request->to,
        ]);
        $notification = notify('Cập nhật ngày lễ thành công');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $holiday = Holiday::find($request->id);
        $holiday->delete();
        $notification = notify('Xóa ngày lễ thành công');
        return back()->with($notification);
    }
}
