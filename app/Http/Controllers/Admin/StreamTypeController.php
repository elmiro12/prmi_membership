<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StreamType;
use Illuminate\Http\Request;

class StreamTypeController extends Controller
{
    public function index()
    {
        $streamTypes = StreamType::all();
        return view('admin.stream_type.index', compact('streamTypes'));
    }

    public function create()
    {
        return view('admin.stream_type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:stream_type,name',
            'amount' => 'required|numeric|min:0',
        ]);

        StreamType::create($request->only('name', 'amount'));

        return redirect()->route('stream-type.index')->with('success', 'Tipe stream berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $type = StreamType::findOrFail($id);
        return view('admin.stream_type.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:stream_type,name,' . $id,
            'amount' => 'required|numeric|min:0',
        ]);

        $type = StreamType::findOrFail($id);
        $type->update($request->only('name', 'amount'));

        return redirect()->route('stream-type.index')->with('success', 'Tipe stream berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $type = StreamType::findOrFail($id);
        $type->delete();

        return redirect()->route('stream-type.index')->with('success', 'Tipe stream berhasil dihapus.');
    }
}

