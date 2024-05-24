<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'assigned_user_id', 'assigned_by_id', 'completed', 'completed_at', 'due_date', 'remarks'
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function getStatusAttribute()
    {
        if ($this->completed) {
            return 'Completed';
        } elseif ($this->due_date < now()) {
            return 'Late';
        } else {
            return 'In Progress';
        }
    }

    public function assignedBy() {
        return $this->belongsTo(User::class, 'assigned_by_id');
    }
}
