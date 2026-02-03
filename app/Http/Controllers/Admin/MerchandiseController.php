<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchandise;

class MerchandiseController extends Controller
{
    public function index()
    {
        $merchandise = Merchandise::all();
        return view('admin.merchandise.index', compact('merchandise'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'merchandise' => 'required|unique:merchandise,name',
        ]);

        Merchandise::create([
            'name' => $request->merchandise,
        ]);

        return back()->with('success', 'Merchandise berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $merhcandise = Merchandise::findOrFail($id);
        
        /*
        $usedBy = $type->memberships()->with('member')->get();

        if ($usedBy->count() > 0) {
            $names = $usedBy->map(function ($membership) {
                return $membership->member->fullname ?? 'Tanpa Nama';
            })->implode(', ');

            return back()->with('error', "Tidak bisa menghapus. Tipe ini sedang digunakan oleh member: $names.");
        }
        */

        $merhcandise->delete();

        return back()->with('success', 'Merchandise berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $merhcandise = Merchandise::findOrFail($id);

        $request->validate([
            'merchandise' => 'required|unique:merchandise,name,' . $merhcandise->id,
        ]);

        $merhcandise->update([
            'name' => $request->merchandise,
        ]);

        return back()->with('success', 'Merhcandise berhasil diperbarui.');
    }
}
