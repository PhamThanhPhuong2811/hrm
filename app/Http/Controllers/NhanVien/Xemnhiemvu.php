<?php

namespace App\Http\Controllers\NhanVien;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Xemnhiemvu extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Danh sách nhiệm vụ';
        $employeeId = auth()->user()->employee_id;

        $tickets = Ticket::where('employee_id','=',$employeeId) 
        ->get();
        return view('NhanVien.Nhiemvu.index',compact(
            'title','tickets'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  string $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {
        $title = 'Xem chi tiết nhiệm vụ';        
        $ticket = Ticket::where('id','=',$ticket_id)->firstOrFail();
        return view('NhanVien.Nhiemvu.show',compact(
            'title','ticket'
        ));
    }
}
