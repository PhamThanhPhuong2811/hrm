<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateCount extends Model
{
    use HasFactory;

    // Tên bảng, nếu khác với tên mặc định
    protected $table = 'late_counts';

    // Các thuộc tính có thể được gán hàng loạt
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'late_count'
    ];
}
