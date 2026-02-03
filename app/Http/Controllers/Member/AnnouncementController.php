<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Extension;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('status', true)
                            ->orderBy('created_at', 'desc')
                            ->paginate(8);

        return view('member.announcements.index', compact('announcements'));
    }

    public function show($id)
    {

        $announcement = Announcement::where('status', true)
                            ->findOrFail($id);

        return view('member.announcements.show', compact('announcement'));
    }
}

