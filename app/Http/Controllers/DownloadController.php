<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class DownloadController extends Controller
{
    public function index()
    {
        
        $layout = Auth::user() ? 'layouts.base' : 'layouts.download-layout';
        return view('download-apk', compact('layout'));
    }

}

