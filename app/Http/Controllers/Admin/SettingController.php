<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Helpers\AppSetting;

class SettingController extends Controller
{
    public function index()
    {
        $setting = DB::table('settings')->first();
        return view('admin.settings.index', compact('setting'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'system_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'webbg' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'profil_pic' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $updateData = ['system_name' => $request->system_name];
        $imgPath = custom_public_path('uploads/');
        
        if ($request->hasFile('profil_pic')) {
            $file = $request->file('profil_pic');
            $filename = 'user_photo_' . Auth::id() . '.' . $file->getClientOriginalExtension();
        
            // hapus foto lama kalau ada
            if (file_exists($imgPath . 'user_photos/' . $filename)) {
                unlink($imgPath . 'user_photos/' . $filename);
            }
        
            // pindahkan file ke folder tujuan
            $file->move($imgPath . 'user_photos/', $filename);
        
            // update kolom photo user login
            Auth::user()->update([
                'photo' => $filename,
            ]);
        }
        
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo.'.$file->getClientOriginalExtension();

            if (file_exists($imgPath.'logo/'. $filename)) {
                unlink($imgPath.'logo/'.$filename);
            }
             $file->move($imgPath.'logo/', $filename);

            $updateData['logo'] = $filename;
        }

        if ($request->hasFile('webbg')) {
            $file = $request->file('webbg');
            $filename = 'webbg.'. $file->getClientOriginalExtension();

            if (file_exists($imgPath.'webbg/'. $filename)) {
                unlink($imgPath.'webbg/'. $filename);
            }
            $file->move($imgPath.'webbg/', $filename);

            $updateData['webbg'] = $filename;
        }

        DB::table('settings')->update($updateData);
        AppSetting::resetCache();

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {

        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password admin berhasil diubah.');
    }
    
    private function getRealPath($path){
        return str_replace('membership/public','membership.madridambon.my.id',public_path($path));
    }
}
