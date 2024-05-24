<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('taskscopy');
    }


    public function adminHome()
    {
        // Fetch all users from the database
        $users = User::where('type', 0)->withCount('tasks')->get();

        // Return the dashboard view and pass the users data to it
        return view('dashboard', compact('users'));
    }


}
