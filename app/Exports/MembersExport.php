<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;

class MembersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Member::with(['user','membership.membershipType'])->get()->map(function ($member) {
            return [
                'Nama' => $member->fullname,
                'Email' => $member->user->email,
                'Kontak' => $member->contact_number,
                'Kode Member' => $member->membership->membership_number ?? '-',
                'Tipe Membership' => $member->membership->membershipType->type ?? '-',
                'Status Member PRMI' => (Str::startsWith($member->membership->membership_number, 'MA')) ? 'NON PRMI' : 'Member PRMI',
                'Tanggal Registrasi' => $member->membership->reg_date ?? '-',
                'Tanggal Expired' => $member->membership->expiry_date ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Kontak',
            'Kode Member',
            'Tipe Membership',
            'Status Member PRMI',
            'Tanggal Registrasi',
            'Tanggal Expired',
        ];
    }
}

