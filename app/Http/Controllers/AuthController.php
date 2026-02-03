<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Verify;
use App\Mail\VerifyAccountMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
       $credentials = $request->only('email', 'password');
       $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $verify = Verify::where('idUser', $user->id)->first();
            if ($verify && $verify->verify == 0 ) {
                return back()->withErrors(['Akun Anda belum diverifikasi. Silakan cek email.']);
            }

            Auth::login($user);
            Session::put('tipeUser', $user->tipeUser); // 'super_admin', 'admin' or 'member'

            if ($user->tipeUser === 'super_admin' || $user->tipeUser === 'admin') {
                return redirect()->route('dashboard'); // admin.dashboard
            }

            if ($user->tipeUser === 'member') {
                return redirect()->route('member.dashboard');
            }

            Auth::logout(); // jika tipe user tidak dikenali
            return redirect()->route('login')->with('error', 'Akun tidak valid.');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }
    
    
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        
        // Cek user
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }
        
        //Cari token aktif yg belum diverifikasi
        $verify = Verify::where('idUser', $user->id)
                    ->where('verify', false)
                    ->first();
    
        if ($verify) {
            $token = $verify->token;
        } else {
            $token = strtoupper(Str::random(6));
            Verify::create([
                'idUser' => $user->id,
                'token' => $token,
                'verify' => false,
            ]);
        }
        
        // Kirim email: token + link
        $resetLink = url("/reset-password/{$token}");

        Mail::raw("Token reset password kamu: {$token}\n\nAtau klik link ini: {$resetLink}", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Reset Password');
        });

        return redirect()->route('reset.password.form')->with('message', 'Token reset password sudah dikirim ke email Anda.');
    }

    /**
     * Tampilkan form reset password dari link (token di URL)
     */
    public function showResetForm($token = null)
    {
        if ($token) {
            // Di frontend: tangkap token → user input password baru
            // Kalau mau, bisa validasi dulu token ada atau tidak
            $verify = Verify::where('token', $token)
                            ->where('verify', false)
                            ->first();
    
            if (!$verify) {
                return redirect()->route('forgot.password.form')
                             ->withErrors(['token' => 'Token tidak valid atau sudah digunakan.']);
            }
    
           return view('auth.reset-password', [
                'token' => $token,
                'email' => $verify->user->email
            ]);
        }
        // Kalau token kosong (misalnya user buka manual)
        return view('auth.reset-password');
    }

    /**
     * Proses reset password: token di URL atau manual input
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|confirmed|min:6',
        ]);

        $verify = Verify::where('token', $request->token)
                        ->where('verify', false)
                        ->first();

        if (!$verify) {
            return response()->json([
                'message' => 'Token tidak valid atau sudah digunakan.'
            ], 400);
        }

        $user = $verify->user;

        $user->password = Hash::make($request->password);
        $user->save();

        $verify->verify = true;
        $verify->save();

        return redirect()->route('login')->with('success', 'Password berhasil direset silahkan login kembali');
    }
    
    public function verifyToken(Request $request)
    {
        
        $request->validate([
            'token' => 'required|string'
        ]);
    
        $verify = Verify::where('token', $request->token)
                        ->where('verify', false)
                        ->first();
    
        if ($verify) {
            return response()->json([
                'status' => 'valid',
                'message' => 'Token valid. Silakan reset password.',
            ]);
        } else {
            return response()->json([
                'status' => 'invalid',
                'message' => 'Token tidak valid',
            ]);
        }
    }
    
    public function resendToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan.'], 404);
        }
    
        $verify = Verify::where('idUser', $user->id)->first();
    
        if (!$verify) {
            return response()->json(['message' => 'Data verifikasi tidak ditemukan.'], 404);
        }
    
        if ($verify->verify) {
            return response()->json(['message' => 'Akun sudah terverifikasi.'], 200);
        }
        
        $now = now();

        // Cek apakah masih dalam jangka waktu 2 menit
        if ($verify->last_resend_at && $verify->last_resend_at->diffInMinutes($now) < 2) {
            if ($verify->resend_count >= 2) {
                return response()->json(['message' => 'Anda telah melebihi batas pengiriman token dalam 2 menit. Silakan tunggu sebentar.'], 429);
            }
        } else {
            // Reset count jika sudah lebih dari 2 menit
            $verify->resend_count = 0;
        }
    
        // Generate token baru
        $token = Str::random(8);
        $verify->token = $token;
        $verify->resend_count += 1;
        $verify->last_resend_at = $now;
        $verify->save();
        
        // Kirim ulang email (gunakan Mail atau notifikasi)
        Mail::to($user->email)->send(new VerifyAccountMail($token));
    
        return response()->json(['message' => 'Token berhasil dikirim ulang. Silakan cek email Anda.'], 200);
    }


    public function dashboard()
    {
        return view('dashboard'); // Buat nanti
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}

