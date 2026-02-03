<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckStreamSubscription
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

        $activeStream = $user->member->streamMemberships()
            ->where('expiry_date', '>=', now())
            ->exists();

        if (!$activeStream) {
           return redirect()->route('member.stream.subscribe')->with('error', 'Langganan streaming tidak aktif. Silakan berlangganan terlebih dahulu.');
        }

        return $next($request);
    }
}
