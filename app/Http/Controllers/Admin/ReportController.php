<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Member;
use App\Models\Extension;
use App\Models\MembershipType;
use Carbon\Carbon;
use PDF;
use App\Exports\MembershipExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function membershipReport()
    {
        $from = Carbon::now()->startOfMonth()->toDateString();
        $to = Carbon::now()->toDateString();
        
        $memberships = $this->getMembership($from, $to);
        
        return view('admin.reports.membership', [
            'memberships' => $memberships,
            'from_date' => $from,
            'to_date' => $to,
        ]);
    }

    public function generateMembershipReport(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ]);

        $from = $request->from_date;
        $to = $request->to_date;
        //dd($from);
        $memberships = $this->getMembership($from, $to);

        return view('admin.reports.membership', [
            'memberships' => $memberships,
            'from_date' => $from,
            'to_date' => $to,
        ]);
    }

    public function exportMembershipPdf(Request $request)
    {
        $from = $request->from_date;
        $to = $request->to_date;

        $memberships = $this->getMembership($from, $to);

        $pdf = PDF::loadView('admin.reports.membership_pdf', compact('memberships', 'from', 'to'));
        return $pdf->download('laporan_membership.pdf');
    }

    public function exportMembershipExcel(Request $request)
    {
        $from = $request->from_date;
        $to = $request->to_date;

        $memberships = $this->getMembership($from, $to);

        return Excel::download(new MembershipExport($memberships, $from, $to), 'laporan_membership.xlsx');
    }

    private function getMembership($from, $to)
    {
        // Ambil ID Membership yang ada di tabel extensions dengan updated_at TIDAK NULL dan updated_at sesuai range
        $extensionMembershipIds = Extension::whereNotNull('idMembership')
            ->whereNotNull('updated_at')
            ->whereBetween('updated_at', [$from, $to])
            ->pluck('idMembership');

        // Ambil data Membership yang punya Extension (updated_at sesuai range)
        $fromExtension = Membership::with('member')
            ->whereIn('id', $extensionMembershipIds)
            ->get();

        // Ambil ID Membership yang pernah perpanjang (regardless of date)
        $allExtendedMembershipIds = Extension::whereNotNull('updated_at')
            ->pluck('idMembership');

        // Ambil data Membership yang BELUM PERNAH perpanjang (updated_at = NULL) dan reg_date sesuai range
        $fromMembership = Membership::with('member')
            ->whereNotIn('id', $allExtendedMembershipIds)
            ->whereBetween('reg_date', [$from, $to])
            ->get();

        // Gabungkan hasil
        $memberships = $fromExtension->merge($fromMembership);

        return $memberships;
    }

}
