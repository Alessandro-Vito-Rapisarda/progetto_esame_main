<?php

namespace App\Http\Controllers;
    use Illuminate\Routing\Controller as BaseController;
    use App\Models\User;
    use Illuminate\Support\Facades\Session;

 class CollectionController extends BaseController
{
    public function home() {
        if (!Session::get('user_id')) {
            return redirect('login');
        }
        $user = User::find(Session::get('user_id'));
        return view('home', ['username' => Session::get('username')]);
    }
}
