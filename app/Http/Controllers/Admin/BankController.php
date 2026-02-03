<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::all();
        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.banks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaBank' => 'required|string|max:100',
            'noRekening' => 'required|string|max:50',
            'namaPemilik' => 'required|string|max:100',
            'statusAktif' => 'required|boolean',
        ]);

        Bank::create($validated);

        return redirect()->route('banks.index')->with('success', 'Bank berhasil ditambahkan.');
    }

    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        $validated = $request->validate([
            'namaBank' => 'required|string|max:100',
            'noRekening' => 'required|string|max:50',
            'namaPemilik' => 'required|string|max:100',
            'statusAktif' => 'required|boolean',
        ]);

        $bank->update($validated);

        return redirect()->route('banks.index')->with('success', 'Bank berhasil diperbarui.');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('banks.index')->with('success', 'Bank berhasil dihapus.');
    }
}
