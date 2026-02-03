<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $member = Auth::user()->member;

        $user = Auth::user();

        if (!$user || !$user->member) {
            return redirect()->route('member.dashboard')->with('error', 'Akses tidak valid.');
        }

        $active = $user->member->membership()
            ->where('expiry_date', '>=', now())
            ->exists();

        if (!$active) {
           return redirect()->route('member.extension')->with('error', 'Membership PRMI tidak aktif. Perpanjang Membership Terlebih Dahulu.');
        }

        return $next($request);
    }
}
