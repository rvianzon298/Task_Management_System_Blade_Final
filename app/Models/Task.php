<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'priority', 'due_date', 'completed', 'completed_at', 'assign_to'];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }
}
