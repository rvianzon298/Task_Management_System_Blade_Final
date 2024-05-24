<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task; // Import the Task model
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function profilepage()
    {
        return view('profile');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
