<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;

    protected $fillable =[
        'employee_id',
        'designation_id',
        'phucap',
        'tre',
        'nghi',
        'total',
        'status',

    ];
    
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    public function designation(){
        return $this->belongsTo(Designation::class);
    }
}