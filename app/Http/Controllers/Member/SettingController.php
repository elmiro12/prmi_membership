<?php

namespace App\Http\Controllers\Member;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $member = Auth::user()->member;
        return view('member.settings.index', compact('member'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required'

        ]);

        DB::table('users')->where('id', Auth::user()->id)->update([
            'email' => $request->email,
            'password' => Hash::make($request->new_password),
            'updated_date' => now(),
        ]);

        return back()->with('success', "Email/Password berhasil diubah.");
    }
}
