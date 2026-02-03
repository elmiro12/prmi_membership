<?php

namespace App\Http\Controllers\Admin;

use App\Models\Club;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::all();
        $primaryExists = Club::where('is_primary', true)->exists();
        return view('admin.clubs.index', compact('clubs', 'primaryExists'));
    }

    public function create()
    {
        $primaryExists = Club::where('is_primary', true)->exists();
        return view('admin.clubs.create', compact('primaryExists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_primary' => 'nullable|boolean',
        ]);

        $club = new Club();
        $club->name = $request->nama;

        if ($request->hasFile('logo')) {
            $filename = time().'_'.$request->logo->getClientOriginalName();
            $photoPath = custom_public_path('uploads/logo_club/');
            $request->logo->move($photoPath, $filename);
            $club->logo = $filename;
        }

        $isPrimary = $request->has('is_primary') ? true : false;

        $club->save();

        return redirect()->route('clubs.index')->with('success', 'Club berhasil ditambahkan.');
    }

    public function edit(Club $club)
    {
        $primaryExists = $club->is_primary;
        return view('admin.clubs.edit', compact('club','primaryExists'));
    }

    public function update(Request $request, Club $club)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $club->name = $request->nama;
        $club->is_primary = $request->is_primary ?? false;

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            $photoPath = custom_public_path('uploads/logo_club/');
            if ($club->logo && file_exists($photoPath.$club->logo)) {
                unlink($photoPath.$club->logo);
            }

            $filename = time().'_'.$request->logo->getClientOriginalName();
            $request->logo->move($photoPath, $filename);
            $club->logo = $filename;
        }

        $club->save();

        return redirect()->route('clubs.index')->with('success', 'Club berhasil diperbarui.');
    }

    public function destroy(Club $club)
    {
        $photoPath = custom_public_path('uploads/logo_club/');
        if ($club->logo && file_exists($photoPath.$club->logo)) {
            unlink($photoPath.$club->logo);
        }

        $club->delete();
        return redirect()->route('clubs.index')->with('success', 'Club berhasil dihapus.');
    }
    
}
