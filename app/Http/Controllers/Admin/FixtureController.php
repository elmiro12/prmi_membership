<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fixture;
use App\Models\Club;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FixtureController extends Controller
{
    public function index() {
        $fixtures = Fixture::with('homeClub', 'awayClub')->latest()->get();
        return view('admin.fixtures.index', compact('fixtures'));
    }

    public function create() {
        $clubs = Club::all();
        return view('admin.fixtures.create', compact('clubs'));
    }

    public function store(Request $request) {
        $request->validate([
            'id_club_home' => 'required|different:id_club_away',
            'id_club_away' => 'required',
            'match_date' => 'required|date',
            'venue' => 'nullable|string',
        ]);

        Fixture::create($request->all());

        return redirect()->route('fixtures.index')->with('success', 'Jadwal pertandingan berhasil ditambahkan');
    }

    public function edit($id) {
        $fixture = Fixture::findOrFail($id);
        $clubs = Club::all();
        return view('admin.fixtures.edit', compact('fixture', 'clubs'));
    }

    public function update(Request $request, $id) {
        $fixture = Fixture::findOrFail($id);
        $fixture->update($request->all());

        return redirect()->route('fixtures.index')->with('success', 'Jadwal pertandingan berhasil diperbarui');
    }

    public function show(Fixture $fixture)
    {
        $fixture->load(['homeClub', 'awayClub']); // pastikan relasi ikut di-load
        return view('admin.fixtures.show', compact('fixture'));
    }

    public function destroy($id) {
        Fixture::findOrFail($id)->delete();
        return redirect()->route('fixture.index')->with('success', 'Jadwal pertandingan berhasil dihapus');
    }
}

