<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Member;
use App\Models\Extension;
use App\Models\Bank;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function create($id)
    {
        $payment = Payment::with('extension')->where('id', $id)->firstOrFail();
        $user = Auth::user();

        $extension = $payment->extension;
        $banks = Bank::where('statusAktif', true)->get();

        return view('member.payment.form', compact('payment','extension', 'banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idBank' => 'required|exists:bank,id',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        
        $payment = Payment::with('extension')->where('id', $request->paymentId)->firstOrFail();
        $extension = $payment->extension;
        
        if (!$extension) {
            return back()->with('error', 'Data perpanjangan tidak ditemukan.');
        }

        $payment = Payment::where('idExtension', $extension->id)
                ->whereNull('status')
                ->whereNull('bukti')
                ->latest()
                ->first();
        if (!$payment) {
            return back()->with('error', 'Data pembayaran belum tersedia atau sudah diproses.');
        }

        // Upload bukti
        $file = $request->file('bukti');
        $filename = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
        $buktiPath = custom_public_path('uploads/bukti');
        $file->move($buktiPath, $filename);

        // Update payment
        $payment->update([
            'idBank' => $request->idBank,
            'bukti' => $filename,
            'updated_at' => now(),
        ]);

        return redirect()->route('member.payment.history')->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    public function history()
    {

        $member = Auth::user()->member()->firstOrFail();

       $payments = Payment::with([
                'extension.membership.membershipType',
                'extension.streamMembership.streamType',
                'bank'
            ])
            ->whereHas('extension', function ($query) use ($member) {
                $query->whereHas('membership', function ($q) use ($member) {
                    $q->where('idMember', $member->id);
                })->orWhereHas('streamMembership', function ($q) use ($member) {
                    $q->where('idMember', $member->id);
                });
            })->orderByDesc('created_at')
            ->get();

        return view('member.payment.history', compact('payments'));
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        // hapus foto jika ada
        if ($payment->bukti && file_exists(custom_public_path('uploads/bukti/' . $payment->bukti))) {
                unlink(custom_public_path('uploads/bukti/' . $payment->bukti));
        }
        //dd($payment);
        $payment->delete();
        return redirect()->route('member.payment.history')->with('success', 'Data Pembayaran berhasil dihapus.');
    }

}

