<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Extension;

class DashboardController extends Controller
{
    public function index()
    {
        // Total member
        $totalMembers = Member::count();

        // Member baru 7 hari terakhir
        $newMembers = Member::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        // Pengumuman terbaru (misal 5 terakhir)
        $announcements = Announcement::where('status', true)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        $user = Auth::user();
        $member = Member::with(['membership','streamMemberships'])->where('idUser', $user->id)->first();
        $membership = $member->membership;
        $expiry_date = $membership->expiry_date;
        $expire = true;
        if(!(is_null($expiry_date)) && !(Carbon::parse($expiry_date)->isPast())){
            $expire = false;
        }

        $paymentBelumUpload = false;

        if ($member && $member->membership) {
            $extension = Extension::where('idMembership', $member->membership->id)
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

        if ($member && $member->streamMemberships) {
            $extension = Extension::where('idStreamMembership', $member->streamMemberships->id)
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


        return view('member.dashboard', compact('member','totalMembers', 'newMembers', 'announcements', 'paymentBelumUpload', 'expire'));
    }
}


