<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StreamType;
use App\Models\StreamMembership;
use App\Models\Extension;
use App\Models\Payment;
use App\Models\Bank;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class StreamMembershipController extends Controller
{
    public function index(){
        $user = Auth::user();
        $member = Member::with('streamMemberships.extension')->where('idUser', $user->id)->first();
        return view('member.stream.index', compact('member'));
    }

    public function subscribe()
    {
        $user = Auth::user();
        $member = Member::with('streamMemberships.extension')->where('idUser', $user->id)->first();
        $paymentBelumUpload = false;

        if ($member && $member->streamMemberships) {
            $extension = Extension::where('idStreamMembership', $member->streamMemberships->id)
                ->whereNotNull('updated_at')
                ->latest()
                ->first();
            if ($extension) {
                $maxId = Payment::where('idExtension', $extension->id)->max('id');
                $latestPayment = Payment::where('id', $maxId)->first();

                if ($latestPayment && is_null($latestPayment->status) && is_null($latestPayment->bukti)) {
                    $paymentBelumUpload = true;
                }
            }
        }

        $streamTypes = StreamType::all();
        return view('member.stream.subscribe', compact('streamTypes', 'paymentBelumUpload'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idStreamType' => 'required|exists:stream_type,id',
        ]);

        $member = Auth::user()->member;

        // Buat stream membership kalau belum ada
        $stream = StreamMembership::firstOrCreate(
            ['idMember' => $member->id],
            [
                'idType' => $request->idStreamType,
                'kode' => 'SM-' . strtoupper(Str::random(6)),
            ]
        );

        // Tambah data extension terkait stream
        $extension = Extension::create([
            'idMembership' => null,
            'idStreamMembership' => $stream->id,
            'updated_at' => now()->toDateString(),
        ]);

        // Tambah payment awal, status belum dibayar
        $bank = Bank::where('statusAktif', true)->first();
        Payment::create([
            'kode' => 'PAY-SM-' . strtoupper(Str::random(6)),
            'idBank' => $bank->id,
            'idExtension' => $extension->id,
            'bukti' => null,
            'status' => null,
        ]);

        return redirect()->route('member.payment.history')->with('success', 'Langganan stream berhasil dibuat. Silakan lakukan pembayaran.');
    }
}

