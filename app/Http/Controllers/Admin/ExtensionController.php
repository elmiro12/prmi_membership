<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Extension;
use App\Models\MembershipType;
use App\Models\Bank;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExtensionController extends Controller
{
    public function index()
    {
        $extensions = Extension::with([
                        'membership.member',
                        'membership.membershipType'
                    ])->get();

        return view('admin.extensions.index', compact('extensions'));
    }

    public function renew($id)
    {
        $extension = Extension::with(['membership.member'])->findOrFail($id);
        $membershipTypes = MembershipType::all();
        $banks = Bank::where('statusAktif', true)->get();

        return view('admin.extensions.renew', compact('extension', 'membershipTypes', 'banks'));
    }

    public function processRenew(Request $request, $id)
    {
        $request->validate([
            'membership_type' => 'required|exists:membership_types,id',
            'bank_id' => 'required|exists:bank,id',
        ]);

        DB::transaction(function () use ($request, $id) {
            $extension = Extension::with('membership')->findOrFail($id);
            $membership = $extension->membership;

            // Update updated_at pada extension
            $extension->updated_at = now();
            $extension->save();

            // Update membership
            $exsist = $membership->tipe_member == $request->membership_type ? 'lama' : 'baru';

            $membership->update([
                'tipe_member' => $request->membership_type,
                'exsist' => $exsist,
            ]);

            // Tambah ke tabel payment
            Payment::create([
                'kode' => 'PAY-'.strtoupper(Str::random(6)),
                'idBank' => $request->bank_id,
                'idExtension' => $extension->id,
                'created_at' => now(),
            ]);
        });

        return redirect()->route('extension.index')->with('success', 'Perpanjangan berhasil diproses!');
    }
}
