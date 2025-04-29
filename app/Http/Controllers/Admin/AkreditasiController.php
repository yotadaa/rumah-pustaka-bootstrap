<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AkreditasiController extends Controller
{
    //
    public function komponen($id, $role_id) {
        $type = 'akreditasi';
        return view('admin.iso.komponen', compact('id', 'role_id','type'));
    }

    public function viewAspek($berkas_id, $komponen_id) {
        return view('admin.akreditasi.aspek', compact('berkas_id','komponen_id'));
    }

    public function viewIndikator($berkas_id, $komponen_id, $aspek_id) {
        return view('admin.akreditasi.indikator', compact('berkas_id','komponen_id','aspek_id'));
    }

}
