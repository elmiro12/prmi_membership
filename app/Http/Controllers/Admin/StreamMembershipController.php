<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StreamMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Extension;
use App\Models\Payment;
use App\Models\Bank;
use App\Models\Member;
use App\Models\StreamType;

class StreamMembershipController extends Controller
{
    public function index()
    {
        $members = Member::with(['streamMemberships.streamType']) // eager load relasi
                ->orderBy('fullname')
                ->get();
        return view('admin.stream_membership.index', compact('members'));
    }

    public function showPerpanjang($id)
    {
        $member = Member::with('streamMemberships.streamType')->findOrFail($id);
        $streamTypes = StreamType::all();

        return view('admin.stream_membership.perpanjang', compact('member', 'streamTypes'));
    }

    public function submitPerpanjang(Request $request, $id)
    {
        $request->validate([
            'idStreamType' => 'required|exists:stream_type,id',
        ]);

        $member = Member::findOrFail($id);

        // cari atau buat stream_membership
        $stream = StreamMembership::firstOrCreate(
            ['idMember' => $member->id],
            ['idType' => $request->idStreamType]
        );

        if ($stream->wasRecentlyCreated) {
            // Buat kode membership: SM-XXXXXX
            $stream->kode = 'SM-' . strtoupper(Str::random(6));
            $stream->save();

            //buat Extension
            Extension::create([
                'idStreamMembership' => $stream->id,
            ]);
        }

        // update tipe stream
        $stream->idType = $request->idStreamType;
        $stream->save();

        // update extension
        $extension = Extension::where('idStreamMembership', $stream->id)->firstOrFail();
        $extension->idStreamMembership = $stream->id;
        $extension->touch(); // update updated_at
        $extension->save();

        // tambah payment
        $bank = Bank::where('statusAktif', true)->first();
        Payment::create([
            'kode' => 'PAY-SM-' . strtoupper(Str::random(6)),
            'idBank' => $bank->id,
            'idExtension' => $extension->id,
            'bukti' => null,
            'status' => null,
        ]);

        return redirect()->route('stream-membership.index')->with('success', 'Perpanjangan berhasil dibuat, menunggu pembayaran.');
    }
}

