<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;

class MemberExportController extends Controller
{
    public function exportPdf()
    {
        $members = Member::with('membership.membershipType')->get();
        $pdf = PDF::loadView('admin.members.export-pdf', compact('members'));
        return $pdf->download('daftar-member.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new MembersExport, 'daftar-member.xlsx');
    }
}

