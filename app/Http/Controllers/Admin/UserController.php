<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('tipeUser','admin')->orWhere('tipeUser','member')
                      ->orderBy('id')
                      ->orderBy('email')
                      ->get();

        return view('admin.users.index', compact('users'));
    }

    public function resetPassword($id)
    {
        DB::table('users')->where('id', $id)->update([
            'password' => bcrypt('password123'),
            'updated_date' => now(),
        ]);

        return back()->with('success', "Password berhasil direset ke password123");
    }

    public function updateEmail(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        DB::table('users')->where('id', $id)->update([
            'email' => $request->email,
            'updated_date' => now(),
        ]);

        return back()->with('success', "Email berhasil diubah.");
    }

}
