<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\Bank;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\MembershipType;
use App\Models\Membership;
use App\Mail\VerifyAccountMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Verify;
use App\Models\Extension;
use App\Models\Merchandise;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class RegisterController extends Controller
{
    public function showForm()
    {
        $types = MembershipType::where('type', '!=', 'PRMI Member')->get();
        $prmiType = MembershipType::where('type', 'PRMI Member')->first();
        $merchandise = Merchandise::all();

        return view('auth.register', compact('types', 'prmiType','merchandise'));
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'contact_number' => 'required|unique:members,contact_number',
            'email' => 'required|email|unique:users,email',
            'instagram' => 'required|string|max:50',
            'address' => 'required',
            'postcode' => 'nullable',
            'occupation' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'required|min:5|confirmed',
        ]);

        DB::beginTransaction();

        $newMembership = false;
        $gender = "Laki-Laki";
        if($request->gender == 'P'){
            $gender = "Perempuan";
        }

        try {
            // Upload foto jika ada
            $photoName = 'default.jpg';
            $photoPath = custom_public_path('uploads/member_photos/');
            if ($request->hasFile('photo')) {
                $photoName = time() . '_' . Str::random(8) . '.' . $request->photo->extension();
                $request->photo->move($photoPath, $photoName);
            }

            // Simpan ke users
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tipeUser' => 'member',
            ]);

            // Simpan ke members
            $member = Member::create([
                'fullname' => $request->fullname,
                'dob' => $request->dob,
                'gender' => $gender,
                'contact_number' => $request->contact_number,
                'instagram' => $request->instagram,
                'address' => $request->address,
                'postcode' => $request->postcode,
                'occupation' => $request->occupation,
                'photo' => $photoName,
                'idUser' => $user->id,
            ]);

            if ($request->has('has_prmi')) {
                // Sudah punya kode member PRMI
                $membership = Membership::create([
                    'idMember' => $member->id,
                    'membership_number' => $request->kode_member,
                    'reg_date' => $request->reg_date,
                    'expiry_date' => $request->expiry_date,
                    'tipe_member' => $request->tipe_member_fixed,
                    'exsist' => 'lama',
                ]);
            } else {

                $kode_member = 'MA-'.strtoupper(Str::random(10));
                // Belum punya, pilih dari dropdown
                $membership = Membership::create([
                    'idMember' => $member->id,
                    'membership_number' => $kode_member,
                    'reg_date' => now()->toDateString(),
                    'tipe_member' => $request->tipe_member_select,
                    'exsist' => 'baru',
                ]);
                $newMembership = true;

            }


            // Simpan ke extensions (belum pernah perpanjang)
            $extension = Extension::create([
                'idMembership' => $membership->id,
                'created_at' => now(),
            ]);

            if($newMembership){

                $bank = Bank::where('statusAktif', true)->first();
                // Generate kode unik
                $kode = 'PAY-' . strtoupper(Str::random(6));

                // Simpan ke tabel payment
                Payment::create([
                    'kode' => $kode,
                    'idExtension' => $extension->id,
                    'idBank' => $bank?->id, // gunakan null-safe operator kalau berjaga-jaga bank kosong
                    'bukti' => null,
                    'status' => null,
                    'created_at' => now(),
                ]);

            }

            DB::commit();
            // Generate token
            $token = Str::random(8);

            // Simpan ke tabel verify
            Verify::create([
                'idUser' => $user->id,
                'token' => $token,
                'verify' => 0,
            ]);

            // Kirim email verifikasi
            Mail::to($user->email)->send(new VerifyAccountMail($token));
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi akun. Jika tidak menerima email, Anda bisa verifikasi manual dengan token.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Registrasi Gagal: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    
    private function getRealPath($path){
        return str_replace('membership/public','membership.madridambon.my.id',public_path($path));
    }

}

