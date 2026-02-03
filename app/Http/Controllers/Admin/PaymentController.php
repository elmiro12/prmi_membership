<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Extension;
use App\Models\Bank;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'bank',
            'extension.membership.membershipType',
            'extension.membership.member',
            'extension.streamMembership.streamType',
            'extension.streamMembership.member',
        ])->latest()->get();

        return view('admin.payment.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with([
            'bank',
            'extension.membership.membershipType',
            'extension.membership.member',
            'extension.streamMembership.streamType',
            'extension.streamMembership.member',
        ])->findOrFail($id);

        return view('admin.payment.show', compact('payment'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:true,false'
        ]);

        $payment = Payment::findOrFail($id);
        $status = $request->status === 'true' ? true : false;
        $payment->status = $status;
        $payment->save();

        if ($status) {
            if($payment->extension->membership){
                $membership = $payment->extension->membership;

                // Update expiry_date 3 tahun dari hari ini
                $membership->expiry_date = date('Y-m-d', strtotime('+3 years'));

                $membership->save();
            }elseif($payment->extension->streamMembership){
                $streamMembership = $payment->extension->streamMembership;
                $streamMembership->expiry_date = date('Y-m-d', strtotime('+1 years'));
                $streamMembership->save();
            }


        }

        return redirect()->route('payments.index')->with('success', 'Status pembayaran berhasil diperbarui.');
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
        return redirect()->route('payments.index')->with('success', 'Data Pembayaran berhasil dihapus.');
    }

}

