<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\Extension;
use App\Models\Announcement;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalIncome = DB::table('payment')
        ->join('extensions', 'payment.idExtension', '=', 'extensions.id')
        ->join('membership', 'extensions.idMembership', '=', 'membership.id')
        ->join('membership_types', 'membership.tipe_member', '=', 'membership_types.id')
        ->where('payment.status', true)
        ->sum('membership_types.amount');

        $latestAnnouncements = Announcement::where('status', true)
        ->latest()
        ->take(2)
        ->get();

        $year = now()->year;

        $pendapatanPerBulan = DB::table('payment')
            ->join('extensions', 'payment.idExtension', '=', 'extensions.id')
            ->join('membership', 'extensions.idMembership', '=', 'membership.id')
            ->join('membership_types', 'membership.tipe_member', '=', 'membership_types.id')
            ->selectRaw("DATE_FORMAT(payment.created_at, '%Y-%m') as bulan, SUM(membership_types.amount) as total")
            ->where('payment.status', true)
            ->groupBy(DB::raw("DATE_FORMAT(payment.created_at, '%Y-%m')"))
            ->orderBy('bulan', 'asc')
            ->get();

        $labels = $pendapatanPerBulan->pluck('bulan')->toArray();
        $data = $pendapatanPerBulan->pluck('total')->toArray();

        return view('admin.dashboard', [
            'totalMembers' => \App\Models\Member::count(),
            'totalAktifMembers' => \App\Models\Membership::whereDate('expiry_date', '>=', $today)->count(),
            'totalMembershipTypes' => \App\Models\MembershipType::count(),
            'totalExtensions' => \App\Models\Extension::count(),
            'totalIncome' => $totalIncome,
            'totalActiveBanks' => \App\Models\Bank::where('statusAktif', true)->count(),
            'totalAnnouncements' => \App\Models\Announcement::where('status', true)->count(),
            'recentMembers' => \App\Models\Member::join('membership', 'members.id', '=', 'membership.idMember')
                ->join('membership_types', 'membership.tipe_member', '=', 'membership_types.id')
                ->whereDate('membership.reg_date', '>=', now()->subDays(7))
                ->select('members.fullname as nama', 'membership.membership_number', 'membership_types.type as tipe')
                ->orderBy('membership.reg_date', 'desc')
                ->take(5)
                ->get(),
            'latestAnnouncements' => $latestAnnouncements,
            'labels' => $labels,
            'data' => $data
            ]);
    }

}

