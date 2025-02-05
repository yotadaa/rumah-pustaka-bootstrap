<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function iso()
    {
        return view('admin.iso.berkas');
    }

    public function login()
    {
        if (!Auth::check()) {
            return view('auth.login');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }

    public function register()
    {
        if (Auth::user()->pangkat == 0) {
            return view('auth.register');
        } else {
            return redirect()->back()->with('error', 'unauthorized');
        }
    }
}
