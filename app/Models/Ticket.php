<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject', 'tk_id', 'employee_id',
        'client_id', 'priority', 'project_id', 'followers',
        'files', 'description', 'status', 'start_date', 'end_date'
    ];

    protected $casts = [
        'followers' => 'array',
        'files' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
