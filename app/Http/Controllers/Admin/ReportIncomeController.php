<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipType;
use App\Models\StreamType;
use App\Models\Payment;
use PDF;

class ReportIncomeController extends Controller
{
    public function index(Request $request)
    {

        $from = $request->from_date ?? now()->startOfMonth()->toDateString();
        $to = $request->to_date ?? now()->toDateString();

        [$reportDataMembership, $totalMembership,
        $reportDataStream, $totalStream, $grandTotal] = $this->generateIncomeReport($from, $to);

        return  view('admin.reports.income',
                compact('reportDataMembership', 'totalMembership',
                'reportDataStream', 'totalStream', 'grandTotal','from', 'to'));
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'from_date' => ['required', 'date'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
        ]);

        $from = $request->from_date;
        $to = $request->to_date;

        [$reportDataMembership, $totalMembership,
        $reportDataStream, $totalStream, $grandTotal] = $this->generateIncomeReport($from, $to);

        $pdf = PDF::loadView('admin.reports.income_pdf', compact('reportDataMembership', 'totalMembership',
                'reportDataStream', 'totalStream', 'grandTotal','from', 'to'));
        return $pdf->download('laporan_pendapatan.pdf');
    }


    /**
     * Generate data laporan pendapatan berdasarkan periode
     *
     * @param string $from
     * @param string $to
     * @return array [$reportData, $totalAll]
     */
    private function generateIncomeReport($from, $to)
    {
        //pendapatan membership
        $membershipTypes = MembershipType::all();
        $reportDataMembership = $membershipTypes->map(function ($type) use ($from, $to) {
            $payments = Payment::with('extension.membership')
                ->where('status', true)
                ->whereBetween('created_at', [$from, $to])
                ->get()
                ->filter(function ($payment) use ($type) {
                    return optional($payment->extension->membership)->tipe_member === $type->id;
                });

            $jumlah = $payments->count();
            $total = $jumlah * $type->amount;

            return [
                'name' => $type->type,
                'amount' => $type->amount,
                'count' => $jumlah,
                'total' => $total,
            ];
        });

        //pendapatan stream
        $streamTypes = StreamType::all();
        $reportDataStream = $streamTypes->map(function ($type) use ($from, $to) {
            $payments = Payment::with('extension.streamMembership')
                ->where('status', true)
                ->whereBetween('created_at', [$from, $to])
                ->get()
                ->filter(function ($payment) use ($type) {
                    return optional($payment->extension->streamMembership)->idType === $type->id;
                });

            $jumlah = $payments->count();
            $total = $jumlah * $type->amount;

            return [
                'name' => $type->name,
                'amount' => $type->amount,
                'count' => $jumlah,
                'total' => $total,
            ];
        });


        $totalMembership = $reportDataMembership->sum('total');
        $totalStream = $reportDataStream->sum('total');

        $grandTotal = $totalMembership + $totalStream;

        return [$reportDataMembership, $totalMembership, $reportDataStream, $totalStream, $grandTotal];
    }

}

