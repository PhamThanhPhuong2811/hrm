<?php

namespace App\Http\Controllers\NhanVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday;

class Xemngayle extends Controller
{
    public function index()
    {
        $title = "Xem ngày lễ";
        $holidays = Holiday::get();
        
        return view('NhanVien.holidays',compact('title','holidays'));
    }
}
