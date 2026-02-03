<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\Extension;
use App\Models\Payment;
use App\Models\User;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with(['user','membership.membershipType','streamMemberships.streamType'])->latest()->get();
        return view('admin.members.index', compact('members'));
    }
    
    public function getOnlyActiveMember()
    {
        $members = Member::with([
                    'user:id,email',
                    'membership:id,idMember,membership_number,exsist,expiry_date,tipe_member', // Pilih kolom membership_number, exsist, expiry_date dari tabel membership
                    'membership.membershipType:id,type' // Pilih kolom type dari tabel membershipType
                ])
                ->whereHas('membership', function ($query) {
                    $query->where('expiry_date', '>', now());  // Filter berdasarkan expiry_date di tabel membership
                })
                ->select('id', 'fullname', 'address','idUser','photo')  // Pilih kolom yang ingin diambil dari tabel `members`
                ->latest()
                ->get();
                
        return response()->json($members);
    }

    public function edit(Member $member)
    {
        $member->load('user');
        $membership = $member->membership; // asumsi relasi 1-1
        $membershipTypes = MembershipType::all();

        return view('admin.members.edit', compact('member', 'membershipTypes'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required',
            'address' => 'required',
            'postcode' => 'required|string',
            'occupation' => 'required|string',
            'contact_number' => 'required|string',
            'instagram' => 'nullable|string',
            'photo' => 'nullable|image',
            'membership_number' => 'required|string',
            'membership_type' => 'required|exists:membership_types,id',
            'reg_date' => 'required|date',
            'expiry_date' => 'required|date',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
        ]);

        // Update Member
        $member->update($request->only([
            'fullname', 'dob', 'gender', 'address', 'postcode',
            'occupation', 'contact_number', 'instagram', 'email'
        ]));

        // Update Photo (optional)
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'-'.$file->getClientOriginalName();
            $photoPath = custom_public_path('uploads/member_photos/');
            $file->move($photoPath, $filename);
        
            // Simpan hanya nama file ke database
            $member->photo = $filename;
            $member->save();
        }

        // Update Membership
        $member->membership->update([
            'membership_number' => $request->membership_number,
            'tipe_member' => $request->membership_type,
            'reg_date' => $request->reg_date,
            'expiry_date' => $request->expiry_date,
        ]);

        // Update Password (if filled)
        if ($request->password) {
            $member->user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('members.index')->with('success', 'Data member berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {

    // Step 1: Hapus payment jika ada
    $membership = $member->membership;
    if ($membership && $membership->extension) {
        foreach ($membership->extension->payments as $payment) {
            $buktipath = custom_public_path('uploads/bukti/');
            // Hapus file bukti jika ada
            if ($payment->bukti && file_exists($buktipath. $payment->bukti)) {
                unlink($buktipath. $payment->bukti);
            }
            $payment->delete();
        }

        // Step 2: Hapus extension
        $membership->extension->delete();
    }
    
    if($membership){
         // Step 3: Hapus membership
        $membership->delete();
    }
   
    
    // Step 4: Hapus payment jika ada
    $streamMembership = $member->streamMemberships;
    if ($streamMembership && $streamMembership->extension) {
        foreach ($streamMembership->extension->payments as $payment) {
            $buktipath = custom_public_path('uploads/bukti/');
            // Hapus file bukti jika ada
            if ($payment->bukti && file_exists($buktipath. $payment->bukti)) {
                unlink($buktipath. $payment->bukti);
            }
            $payment->delete();
        }

        // Step 5: Hapus extension
        $streamMembership->extension->delete();
    }

    if($streamMembership){
        // Step 6: Hapus stream membership
        $streamMembership->delete();
    }
    

    // Step 7: Hapus foto profil member jika ada
    $photoPath = custom_public_path('uploads/member_photos/');
    if ($member->photo && file_exists($photoPath . $member->photo)) {
        unlink($photoPath . $member->photo);
    }

    //Step 8 : simpan user sementara
    $user = $member->user;

    // Step 9: Hapus member dulu, agar tidak nyantol ke users
    $member->delete();

    // Step 10: Hapus user
    if ($user) {
        $user->delete();
    }

    return redirect()->back()->with('success', 'Member dan seluruh data relasinya berhasil dihapus.');
    }

}
