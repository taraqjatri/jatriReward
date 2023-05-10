<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function loginView(): View|RedirectResponse
    {
        if(Auth::check()) return redirect('/');
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])){
            return redirect('/');
        }
        return redirect('/login')->withErrors(['email'=> $request->email]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/login');
    }
}
