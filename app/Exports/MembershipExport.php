<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MembershipExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $data;
    protected $from_date;
    protected $to_date;

    public function __construct($data, $from_date, $to_date)
    {
        $this->data = $data;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function collection()
    {
        return collect($this->data)->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Nama Member' => $item->member->fullname ?? '-',
                'Kode Member' => $item->membership_number,
                'Tipe' => $item->membershipType->nama ?? '-',
                'Tanggal Registrasi' => \Carbon\Carbon::parse($item->reg_date)->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            ["Laporan Membership"],
            ["Dari tanggal " . \Carbon\Carbon::parse($this->from_date)->format('d M Y') . " sampai " . \Carbon\Carbon::parse($this->to_date)->format('d M Y')],
            [], // baris kosong
            ['No', 'Nama Member', 'Kode Member', 'Tipe', 'Tanggal Registrasi']
        ];
    }

    public function title(): string
    {
        return 'Laporan Membership';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // header style
            4 => ['font' => ['bold' => true]],
        ];
    }
}

