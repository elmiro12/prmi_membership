<?php

namespace App\Http\Controllers\Member;

use App\Models\Fixture;
use App\Models\Club;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FixtureController extends Controller
{
    public function index() {
        $fixtures = Fixture::with('homeClub', 'awayClub')->latest()->get();
        return view('member.fixtures.index', compact('fixtures'));
    }
    public function show($id)
    {
        $fixture = Fixture::with('homeClub', 'awayClub')->findOrFail($id);
        return view('member.fixtures.show', compact('fixture'));
    }
}

