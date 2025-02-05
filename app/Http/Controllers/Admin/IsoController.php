<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IsoController extends Controller
{
    //
    public function divisi($id) {
        return view('admin.iso.divisi', compact('id'));
    }

    public function komponen($id, $role_id) {
        return view('admin.iso.komponen', compact('id', 'role_id'));
    }

    public function kelolaKomponen($berkasId, $komponenId, $role_id) {
        return view('admin.iso.komponen.kelola', compact('berkasId', 'komponenId', 'role_id'));
    }
}
