<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch all users from the database
        $users = User::all();

        // Return the dashboard view and pass the users data to it
        return view('dashboard', compact('users'));
    }
}
