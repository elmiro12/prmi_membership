<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\Member;

class MembershipVerificationController extends Controller
{
    public function index()
    {
        $memberships = Membership::with(['member', 'member.user'])
            ->get();

        return view('admin.verify_membership.index', compact('memberships'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'membership_number' => 'required|string|unique:membership,membership_number,' . $id,
            'verify' => 'nullable|in:on',
            'reg_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:reg_date',
        ]);

        $membership = Membership::findOrFail($id);
        $membership->membership_number = $request->membership_number;
        $membership->reg_date = $request->reg_date;

        if ($request->verify === 'on') {
            $membership->expiry_date = $request->expiry_date;
        } else {
            $membership->expiry_date = null;
        }

        $membership->save();

        return redirect()->route('verify-membership.index')->with('success', 'Membership berhasil diverifikasi.');
    }
}

