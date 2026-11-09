<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Session;
use App\Models\User;

class LoginController extends BaseController
{

    public function login_form()
    {
        if (Session::get('user_id')) {
            return redirect('home');
        }
        $error = Session::get('error');
        Session::forget('error');
        return view('login')->with('error', $error);
    }

    public function do_login()
    {
        if (Session::get('user_id')) {
            return response()->json(['success' => true, 'redirect' => url('home')]);
        }

        if (strlen(request('username')) == 0 || strlen(request('password')) == 0) {
            $error = 'Inserisci username e password';
            return response()->json(['success' => false, 'error' => $error]);
        }

        $user = User::where('username', request('username'))->first();
        if (!$user || !password_verify(request('password'), $user->password)) {
            $error = 'Credenziali non valide';
            return response()->json(['success' => false, 'error' => $error]);
        }

        Session::put('user_id', $user->id);
        Session::put('username', $user->username);
        
        return response()->json(['success' => true, 'redirect' => url('home')]);
    }

    public function register_form()
    {
        if (Session::get('user_id')) {
            return redirect('home');
        }
        $error = Session::get('error');
        Session::forget('error');
        return view('register')->with('error', $error);
    }

    public function do_register()
    {
        if (Session::get('user_id')) {
            return redirect('home');
        }
        
        if (strlen(request('username')) == 0 || strlen(request('password')) == 0) {
            Session::put('error', 'dati mancanti');
            return redirect('register')->withInput();
        } else if (request('password') != request('conferma')) {
            Session::put('error', 'le password non corrispondono');
            return redirect('register')->withInput();
        } else if (User::where('username', request('username'))->first()) {
            Session::put('error', 'nome utente già esistente');
            return redirect('register')->withInput();
        } else if (
            strlen(request('password')) < 8 ||
            !preg_match('/[a-z]/', request('password')) ||
            !preg_match('/[A-Z]/', request('password')) ||
            !preg_match('/[0-9]/', request('password')) ||
            !preg_match('/[\W]/', request('password'))
        ) {
            Session::put('error', 'password insicura');
            return redirect('register')->withInput();
        }

        $user = new User();
        $user->username = request('username');
        $user->password = password_hash(request('password'), PASSWORD_BCRYPT);
        $user->save();
        return redirect('login');
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }
}