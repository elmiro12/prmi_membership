<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipType;
use App\Models\Merchandise;

class MembershipTypeController extends Controller
{
    public function index()
    {
        $types = MembershipType::all();
        $merchandise = Merchandise::all();
        return view('admin.membership_types.index', compact('types','merchandise'));
    }
    
    public function create()
    {
        $merchandise = Merchandise::all();
        return view('admin.membership_types.create', compact('merchandise'));
    }
    
    public function edit($id)
    {
        $type = MembershipType::findOrFail($id);
        $merchandise = Merchandise::all();
        return view('admin.membership_types.edit', compact('type','merchandise'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|unique:membership_types,type',
            'amount' => 'required|numeric|min:0',
            'merchandise' => 'nullable|array',
            'merchandise.*' => 'integer|exists:merchandise,id', // opsional, tapi direkomendasikan
        ]);

        MembershipType::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'merchandise'=> $request->merchandise,
        ]);

        return redirect()->route('membership-types.index')->with('success', 'Tipe membership berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $type = MembershipType::findOrFail($id);

        $usedBy = $type->memberships()->with('member')->get();

        if ($usedBy->count() > 0) {
            $names = $usedBy->map(function ($membership) {
                return $membership->member->fullname ?? 'Tanpa Nama';
            })->implode(', ');

            return redirect()->route('membership-types.index')->with('error', "Tidak bisa menghapus. Tipe ini sedang digunakan oleh member: $names.");
        }

        $type->delete();

        return redirect()->route('membership-types.index')->with('success', 'Tipe membership berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $type = MembershipType::findOrFail($id);
        $request->validate([
            'type' => 'required|unique:membership_types,type,' . $type->id,
            'amount' => 'required|numeric|min:0',
            'merchandise' => 'nullable|array',
            'merchandise.*' => 'integer|exists:merchandise,id',
        ]);

        $type->update([
            'type' => $request->type,
            'amount' => $request->amount,
            'merchandise' => $request->merchandise
        ]);

        return redirect()->route('membership-types.index')->with('success', 'Tipe membership berhasil diperbarui.');
    }

}

