<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use Carbon\Carbon;
use App\Models\MembershipType;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Payment;
use App\Models\Extension;
use App\Models\Merchandise;
use Illuminate\Support\Str;

class ExtensionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $member = Member::with([
            'membership.membershipType'
        ])->where('idUser', $user->id)->first();

        if (!$member || !$member->membership) {
            return redirect()->back()->with('error', 'Data membership tidak ditemukan.');
        }

        $membership = $member->membership;
        $type = $membership->membershipType;
        $merchandise = Merchandise::all();
        
        $selected = collect($type->merchandise)->map(fn($id) => (int) $id)->toArray();
        $merchand = $merchandise->filter(fn($m) => in_array($m->id, $selected));
        
        // Ambil data extension dari membership ID
        $extension = \App\Models\Extension::where('idMembership', $membership->id)->first();

        $status = Carbon::parse($membership->expiry_date)->isPast() ? 'Expired' : 'Active';

        return view('member.extensions.index', compact(
            'membership',
            'extension',
            'merchand',
            'type',
            'status'
        ));
    }

    public function create()
    {
        $user = Auth::user();

        $member = Member::with('membership')->where('idUser', $user->id)->firstOrFail();
        $membership = $member->membership;
        $reg_date = $membership->reg_date;
        $expiry_date = $membership->expiry_date;

        if(is_null($expiry_date)){
            $expiry_date = date('Y-m-d', strtotime('+3 years', strtotime($reg_date)));
           // dd($expiry_date);
        }else{
            $reg_date = date('Y-m-d');
            $expiry_date = date('Y-m-d', strtotime('+3 years'));
        }
        // Ambil tipe membership KECUALI yang 'PRMI Member' atau amount = 0
        $types = MembershipType::where('type', '!=', 'PRMI Member')
            ->where('amount', '>', 0)
            ->get();
            
        $merchandise = Merchandise::all();

        return view('member.extensions.form', compact('membership', 'types', 'reg_date', 'expiry_date','merchandise'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_member' => 'required|integer|exists:membership_types,id'
        ]);

        $user = Auth::user();
        $member = Member::with('membership')->where('idUser', $user->id)->firstOrFail();
        $membership = $member->membership;

        try {
            \DB::beginTransaction();

            // Update membership
            $membership->update([
                'tipe_member' => $request->tipe_member,
                'reg_date' => now()->toDateString(),
            ]);

            $extension = Extension::where('idMembership', $membership->id)->first();
            if ($extension) {
                $updateExt = $extension->update([
                                'updated_at' => now()->toDateString(),
                            ]);
                $extension->save();
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
                    'created_at' => now()->toDateString(),
                ]);
            }

            \DB::commit();

            return redirect()->route('member.payment.form')->with('success', 'Perpanjangan berhasil, silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperpanjang: ' . $e->getMessage());
        }
    }


}

