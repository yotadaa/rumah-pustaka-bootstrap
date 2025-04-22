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

}
