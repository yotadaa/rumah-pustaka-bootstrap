<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            'Pedoman Mutu',
            'Pengendalian Dokumen',
            'Audit Internal',
            'Tinjauan Manajemen',
            'Ketidaksesuaian dan Tindakan Perbaikan',
            'Penanganan Keluhan Pelanggan',
            'Sirkulasi',
            'Survei Kepuasan Pelanggan',
            'Penanganan Permintaan Pelanggan',
            'Rekrutmen',
            'Monitoring dan Evaluasi Kinerja Tenaga Kerja',
            'Kompetensi SDM',
            'Pelatihan',
            'Pengadaan',
            'Keuangan',
            'IT',
            'Administrasi',
            'Referensi',
            'Repositori',
            'Kebersihan',
            'Keamanan',
            'Preservasi',
            'Pengolahan',
        ];

        foreach ($roles as $role) {
            Role::insert([
                'name' => $role,
                'level' => 1,
            ]);
        }
    }
}
