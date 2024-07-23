<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerSave(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => "0"
        ]);

        return redirect()->route('login');
    }

    public function login()
    {
        return view('auth/login');
    }




    public function insecureLoginAction(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

        try {
            $results = \DB::select($query);
        } catch (QueryException $e) {

            return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        }

        $user = null;
        foreach ($results as $result) {
            if ($result->email == $email) {
                $user = $result;
                break;
            }
        }

        if ($user) {
            \Auth::loginUsingId($user->id);
            $request->session()->regenerate();

            if ($user->type == 0) {
                return redirect()->route('taskscopy/index');
            } else {
                return redirect()->route('admin/home');
            }
        }

        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }



    public function secureLoginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = DB::table('users')->where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::loginUsingId($user->id);
            $request->session()->regenerate();

            if ($user->type == 0) {
                return redirect()->route('taskscopy/index');
            } else {
                return redirect()->route('admin/home');
            }
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function checkLoginType(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');


        $isInsecure = strpos($password, " or") !== false;

        return response()->json(['insecure' => $isInsecure]);
    }

}
