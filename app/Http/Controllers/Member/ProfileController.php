<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Extension;
use Carbon\Carbon;
use PDF;

class ProfileController extends Controller
{
    public function index()
    {
        $member = Member::with('membership')->where('idUser', Auth::id())->firstOrFail();
        $membership = $member->membership;
        $status = Carbon::parse($membership->expiry_date)->isPast() ? 'Expired' : 'Active';

        return view('member.profile.index', compact('member','status'));
    }

    public function edit()
    {
        $member = Member::with('membership')->where('idUser', Auth::id())->firstOrFail();
        return view('member.profile.edit', compact('member'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'contact_number' => 'required',
            'instagram' => 'nullable|string|max:50',
            'address' => 'required|string',
            'postcode' => 'nullable|string|max:10',
            'occupation' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048',
        ]);

        $member = Member::where('idUser', Auth::id())->firstOrFail();

        $data = $request->except(['photo']);
        if ($request->hasFile('photo')) {
            $photoName = time().'_'.$request->file('photo')->getClientOriginalName();
            $photoPath = custom_public_path('uploads/member_photos/');

            if ($member->photo && file_exists($photoPath . $member->photo)) {
                unlink($photoPath. $member->photo);
            }

            $request->file('photo')->move($photoPath, $photoName);
            $data['photo'] = $photoName;
        }

        $member->update($data);

        return redirect()->route('member.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function downloadCard()
    {
        $member = Member::with('membership')->where('idUser', Auth::id())->firstOrFail();
        $membership = $member->membership;
        $extension = Extension::where('idMembership', $membership->id)->firstOrFail();
        $expire = Carbon::parse($membership->expiry_date)->isPast();

        if(is_null($extension->updated) && $expire){
            return back()->withErrors(['error' => 'Membership Expire, Lakukan Perpanjangan Membership !'])->withInput();
        }
        
        if($membership->exsist === 'baru'){
            $maxid = Payment::where('idExtension', $extension->id)->max('id'); //payment terakhir
            $payment = Payment::where('id', $maxid)->first();
            if(!$payment || !$payment->status){
                return back()->withErrors(['error' => 'Membership Anda Belum Diverifikasi/Ditolak'])->withInput();
            }
        }

        $pdf = PDF::loadView('member.profile.card', compact('member'))->setPaper('A7', 'landscape');
        return $pdf->download('kartu-member-'.$member->fullname.'.pdf');
    }
    
    public function previewCard()
    {
        $member = Member::with('membership')->where('idUser', Auth::id())->firstOrFail();
        $membership = $member->membership;
        $extension = Extension::where('idMembership', $membership->id)->firstOrFail();
        $expire = Carbon::parse($membership->expiry_date)->isPast();

        if(is_null($extension->updated) && $expire){
            return back()->withErrors(['error' => 'Membership Expire, Lakukan Perpanjangan Membership !'])->withInput();
        }
        
        if($membership->exsist === 'baru'){
            $maxid = Payment::where('idExtension', $extension->id)->max('id'); //payment terakhir
            $payment = Payment::where('id', $maxid)->first();
            if(!$payment || !$payment->status){
                return back()->withErrors(['error' => 'Membership Anda Belum Diverifikasi/Ditolak'])->withInput();
            }
        }

        return view('member.profile.preview-card', compact('member'));
    }
    
}

