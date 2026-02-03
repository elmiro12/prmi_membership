<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcement.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'isi' => 'required',
            'namaFile' => 'nullable|file|mimes:pdf,doc,docx,zip',
        ]);

        $fileName = null;
        if ($request->hasFile('namaFile')) {
            $fileName = time() . '_' . $request->namaFile->getClientOriginalName();
            $request->namaFile->move(custom_public_path('uploads/pengumuman'), $fileName);
        }

        Announcement::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'isi' => $request->isi,
            'namaFile' => $fileName,
            'status' => $request->status ?? false,
        ]);

        return redirect()->route('announcement.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcement.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'isi' => 'required',
            'namaFile' => 'nullable|file|mimes:pdf,doc,docx,zip',
        ]);

        $fileName = $announcement->namaFile;
        if ($request->hasFile('namaFile')) {
            if ($fileName && file_exists(custom_public_path('uploads/pengumuman/' . $fileName))) {
                unlink(custom_public_path('uploads/pengumuman/' . $fileName));
            }

            $fileName = time() . '_' . $request->namaFile->getClientOriginalName();
            $request->namaFile->move(custom_public_path('uploads/pengumuman'), $fileName);
        }

        $announcement->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'isi' => $request->isi,
            'namaFile' => $fileName,
            'status' => $request->status ?? false,
        ]);

        return redirect()->route('announcement.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->namaFile && file_exists(custom_public_path('uploads/pengumuman/' . $announcement->namaFile))) {
            unlink(custom_public_path('uploads/pengumuman/' . $announcement->namaFile));
        }

        $announcement->delete();
        return redirect()->route('announcement.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(custom_public_path('uploads/pengumuman/images'), $filename);

            return response()->json([
                'location' => asset('uploads/pengumuman/images/' . $filename)
            ]);
        }
        return response()->json(['error' => 'Tidak ada file diupload'], 400);
    }
}
