<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (in_array($user->tipeUser, ['admin', 'super_admin'])) {
                return redirect()->route('dashboard');
            }
    
            if($user->tipeUser === 'member'){
                return redirect()->route('member.dashboard');
            }
            // jika tipe user tidak valid
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun tidak dikenali');
        }
        return redirect()->route('login');
    }
}
