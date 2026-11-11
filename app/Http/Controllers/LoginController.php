<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login_form()
    {
        return view('login');
    }

    public function do_login(LoginRequest $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return back()->withInput($request->only('username'))
                         ->withErrors(['credenziali' => 'Credenziali non valide.']);
        }

        $request->session()->regenerate();
        $request->session()->put('user_id', $user->id);
        $request->session()->put('username', $user->username);

        return redirect('home');
    }

    public function register_form()
    {
        return view('register');
    }

    public function do_register(RegisterRequest $request)
    {
        $user = new User();
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect('login')->with('status', 'Registrazione completata, ora puoi accedere.');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
