<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task; // Import the User model

class DashboardController extends Controller
{
    public function base()
    {
        // Count total users
        $totalUsers = User::where('type', 0)->count();

        // Count total assigned tasks
        $totalAssignedTasks = Task::count();

        // Count total completed tasks
        $totalCompletedTasks = Task::where('completed', true)->count();



        return view('tasks.base', compact('totalUsers', 'totalAssignedTasks', 'totalCompletedTasks'));
    }


}
