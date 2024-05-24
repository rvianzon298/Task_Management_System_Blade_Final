<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function viewTasks($userId)
    {
        // Logic to fetch paginated tasks for the specified user
        $user = User::findOrFail($userId);
        $tasks = $user->tasks()->paginate(5); // Paginate tasks with 10 tasks per page

        // Pass the paginated tasks data to the view
        return view('tasks.index', compact('tasks'));
    }
}
