<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Berkas;
use App\Models\KomponenIso;
use App\Models\Role;
use App\Models\Komponen;
use App\Models\Access;
use App\Models\User;
use App\Models\UserAccess;

class BerkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uuid = 'a94d6b12-d5d5-4013-a580-7c3705ca6079';
        Berkas::create([
            'id' => $uuid,
            'name' => 'Dokumen ISO Februari 2025',
            'model' => 'iso',
        ]);

        $komponenId = [
            '0016425b-08fc-439b-bbe2-74656beabe18',
            '04410faf-d58f-4830-9a1a-439ca6ba285c',
            '09f32cf7-9384-49d9-a522-1b01b9172ccf',
            '0f00a89f-38bf-4999-8a62-6f35359f6a2c',
            '0fb8e10f-3323-4c78-b813-49fdbe59adde',
            '10c25398-5bc1-4a02-baca-fc13fb105e01',
            '12b32883-1305-4edd-a3cc-7108dd7673e8',
            '15df9ab9-e226-4b10-ad64-4343023f4830',
            '16352795-5b85-4530-b911-697c5096fef3',
            '198570ea-460a-4dae-923f-d3de7992ba84',
            '19e620e0-d61b-48ca-b987-1bdde53d1db9',
            '1defd341-62a0-4d5b-8dc8-c2de3084f13d',
            '1e4b91e9-f0a4-457d-8743-da305e74256a',
            '230d7083-4ce4-43d1-b357-8a76dbaac4f3',
            '23a22603-e057-434e-9822-a39fc2b477fc',
            '258ce865-49ea-4cfc-8f98-8dfe92f6a179',
            '274b2175-5a12-4d4a-abc1-7e0286ed277d',
            '2904db2f-e52c-488f-b88d-b50671814afb',
            '2ac3b5e7-87f9-4473-b4c2-bf5ff8e47e74',
            '2c56618e-52af-49fc-8b6d-767540acb460',
            '2c56ba06-5ac5-4039-b845-9d1c4bde7cc8',
            '2e439ad1-f751-4f25-9254-f088909c7fe7',
            '35166021-148e-40d5-8744-29bb832bef18',
            '3b315a58-624e-40e0-ba21-d6ee7c73ead9',
            '3c6289e6-d312-4bd4-af77-839572ac5e17',
            '3d289e89-a1de-4e87-ac90-27b538742639',
            '3fb47ab2-5d90-4886-bac4-df15b6f20ab7',
            '487a4ce0-b8ff-465b-a1ad-0cecc7572283',
            '5d06b039-396b-4bd1-b412-299ab9f93c51',
            '61ca7df0-f1cf-4684-8262-41e3f0a570c0',
            '64d1b668-5944-4263-b04b-ed29e51a4331',
            '68083850-5296-438e-876c-d9a29c494a42',
            '6828e876-bd23-40ca-9d37-016a1911e6f8',
            '6fbc3b9e-cbc2-467e-b31a-ba2d7140c8d0',
            '707c865f-e47a-4cf8-a002-708ff709a8e5',
            '770446df-b0d7-40d5-83ee-5a976e2ecae0',
            '788c5ca6-be61-4fb0-8ff5-5289685c0f44',
            '80961b1e-460f-4190-b81c-3e53e262a189',
            '8551b555-ef8d-417e-adef-8c47ba75e3c3',
            '8917d3a6-735f-43b5-bb0a-f58652741e72',
            '8c11967e-8a8f-40bc-93d7-b9b7981e5886',
            '8dceb604-4610-4918-9db0-eafe22ef85c8',
            'a091c722-e6c0-4702-be01-ef5209c80809',
            'a135f80f-6343-4602-8f6c-1cef6de85d15',
            'a2cd20c8-e204-4c50-9f27-6f7d1ca730a7',
            'a3caf816-dd88-4744-8306-4123d9eccc03',
            'a715c195-e8ed-4f08-8ecd-c53e37685280',
            'afadb078-0c98-47c9-98cf-1939a904410a',
            'b10406cd-4ee6-4ba1-b64f-45b4e64c66cc',
            'b5582181-f930-470d-aefa-05dd75f9bc0c',
            'b8a807d9-6088-4792-8ed4-a16f10786926',
            'bd1271ce-4378-4670-a55b-ec2c7af7e769',
            'bd335fd7-337c-4bd8-99a9-6c80f64e3656',
            'c3c6876a-97be-4d91-be31-d623a20801d7',
            'cbed1bda-a95e-410c-b31a-619eadfd83b7',
            'd33ff8a7-242f-4182-9520-f4d946fd5488',
            'd78ffef3-61a0-4747-81c7-dfbada299b32',
            'd7ebccda-85c5-42e9-8c96-26a14a2e0d2b',
            'd91bee83-2d82-40ee-8e82-143072af0fdf',
            'd974ab18-da9d-45f4-85f9-52032dbc812b',
            'ddddfca9-6dbe-4545-8cf5-0e4677f653d9',
            'e14ee466-c24c-4484-8658-1b7cc62f5c4b',
            'e2972542-85f8-4fe8-ba24-97f0f25ce005',
            'e4cbcf91-fdd5-4333-941d-f86a0bff94c4',
            'e72e45b6-cf3a-47a6-a0eb-ddfd85c483a8',
            'eb6a9836-7213-4901-a55e-b8b19cc50f85',
            'ecdbe595-bf79-462c-bf3b-3fe44805399b',
            'f0c4b400-2f3e-4b6a-ade8-abc2d4bbcedc',
            'f656b677-9710-43c5-adc3-00eb4db88cec',
            'f7699b8b-3e5a-4635-972b-b3a3beb4dd32',
        ];

        $komponen = [
            '4. Konteks Organisasi',
            '4.1. Memahami Organisasi dan Konteksnya',
            '4.2. Memahami Kebutuhan & Harapan Interested Parties',
            '4.3. Menentukan Ruang Lingkup SMM',
            '4.4. SMM dan Prosesnya',
            '5. Kepemimpinan',
            '5.1. Kepemimpinan dan Komitmen',
            '5.1.1. Umum',
            '5.1.2. Fokus pada Pelanggan',
            '5.2. Kebijakan',
            '5.2.1. Menetapkan Kebijakan Mutu',
            '5.2.2. Mengkomunikasikan Kebijakan Mutu',
            '5.3. Peran. Tanggung Jawab dan Wewenang Organisasi',
            '6. Perencanaan',
            '6.1. Tindakan untuk Mengatasi Risiko dan Peluang',
            '6.2. Sasaran Mutu dan Rencana untuk  Mencapainya',
            '6.3. Perubahan Perencanaan',
            '7. Pendukung',
            '7.1. Sumber Daya',
            '7.1.1. Umum',
            '7.1.2. Orang',
            '7.1.3. Infrastruktur',
            '7.1.4. Lingkungan untuk Proses Operasional',
            '7.1.5. Sumber Pemantauan dan Pengukuran',
            '7.1.6. Pengetahuan Organisasi',
            '7.2. Kompetensi',
            '7.3. Pengetahuan',
            '7.4. Komunikasi',
            '7.5. Informasi Terdokumentasi',
            '7.5.1. Umum',
            '7.5.2. Membuat dan Memperbaharui',
            '7.5.3. Pengendalian Informasi yang terdokumentasi',
            '8. Operasional',
            '8.1. Perencanaan dan Pengendalian Operasional',
            '8.2. Persyaratan untuk Produk dan Jasa',
            '8.2.1. Komunikasi Pelanggan',
            '8.2.2. Menentukan Persyaratan untuk Produk & Jasa',
            '8.2.3. Tinjauan Persyaratan Produk & Jasa',
            '8.2.4. Perubahan Persyaratan Produk & Layanan',
            '8.3. Desain dan Pengembangan Produk & Layanan',
            '8.3.1. Umum',
            '8.3.2. Perencanaan Desain & Pengembangan',
            '8.3.3. Masukan Desain & Pengembangan',
            '8.3.4. Pengendalian Desain & Pengembangan',
            '8.3.5. Keluaran Desain & Pengembangan',
            '8.3.6. Perubahan desain & Pengembangan',
            '8.4. Pengendalian Proses. Produk. & Jasa Eksternal yang tersedia',
            '8.4.1. Umum',
            '8.4.2. Jenis dan Tingkat Pengendalian',
            '8.4.3. Informasi untuk Penyedia Eksternal',
            '8.5. Penyediaan Produk dan Jasa',
            '8.5.1. Pengendalian Penyedianan Produksi & Jasa',
            '8.5.2. Identifikasi dan Mampu Telusur',
            '8.5.3. Properti Milik Pelanggan/Penyedia Eksternal',
            '8.5.4. Pemeliharaan',
            '8.5.5. Kegiatan Setelah Pengiriman',
            '8.5.6. Pengendalian Perubahan',
            '8.6. Rilis Produk & Jasa',
            '8.7. Pengendalian Ketidaksesuaian Output',
            '9. Evaluasi Kinerja',
            '9.1. Pemantauan. Pengukura. analisa dan Evaluasi',
            '9.1.1. Umum',
            '9.1.2. Kepuasan Pelanggan',
            '9.1.3. Analisa dan Evaluasi',
            '9.2. Audit Internal',
            '9.3. Tinjauan Manajemen',
            '10. Perbaikan',
            '10.1. Umum',
            '10.2. Ketidaksesuaian dan Tindakan Perbaikan',
            '10.3. Perbaikan Terus Menerus',
        ];

        foreach ($komponen as $index => $k) {
            Komponen::create([
                'id' => $komponenId[$index] ?? null,
                'name' => $k,
                'model' => 'iso',
            ]);
        }

        $roles = ['Pedoman Mutu', 'Pengendalian Dokumen', 'Audit Internal', 'Tinjauan Manajemen', 'Ketidaksesuaian dan Tindakan Perbaikan', 'Penanganan Keluhan Pelanggan', 'Sirkulasi', 'Survei Kepuasan Pelanggan', 'Penanganan Permintaan Pelanggan', 'Rekrutmen', 'Monitoring dan Evaluasi Kinerja Tenaga Kerja', 'Kompetensi SDM', 'Pelatihan', 'Pengadaan', 'Keuangan', 'IT', 'Administrasi', 'Referensi', 'Repositori', 'Kebersihan', 'Keamanan', 'Preservasi', 'Pengolahan'];

        $user = User::create([
            'email' => 'mukhtadanasution@gmail.com',
            'password' => bcrypt('password'),
            'pangkat' => 0,
            'name' => 'Mukhtada'
        ]);

        foreach ($roles as $index => $role) {
            Role::insert([
                'name' => $role,
                'level' => 1,
            ]);

            UserAccess::create([
                'role_id' => $index,
                'user_id' => $user->id,
            ]);
        }

        $matrix = [
            [1, 3, 4, 10, 11, 12],
            [1, 3, 4, 11, 12],
            [1, 3, 4, 9, 13],
            [1, 4, 11, 12],
            [1, 11, 12],
            [1, 4, 12],
            [1, 4, 12],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 7, 8, 9, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 4, 5, 11, 12],
            [1, 2, 4, 5],
            [1, 4],
            [1, 4, 8, 9, 11, 12],
            [1, 4, 5, 11, 12],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 4, 11],
            [1, 2, 11, 12],
            [1, 11, 12],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 3, 4, 7, 8, 9, 11, 12, 13, 23],
            [1, 3],
            [1, 3, 4, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 5, 6],
            [1, 2],
            [1, 4, 11, 12],
            [1, 3, 4, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 7, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 6, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 7, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 6, 7, 8, 18, 19, 21, 23],
            [1, 2, 7, 13, 14, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 7, 13, 14, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 7, 13, 14, 16, 17, 18, 19, 20, 21, 22, 23],
            [],
            [],
            [],
            [],
            [],
            [],
            [],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 16, 20, 21, 22],
            [1, 2, 9, 14, 23],
            [1, 2, 9, 14, 23],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 7, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
            [1, 7, 8, 9, 18, 19, 20, 21],
            [1, 6, 8],
            [1, 3, 7, 8, 13, 14, 17, 18, 19, 20, 21, 22, 23],
            [1, 4, 5],
            [1, 2, 5, 22],
            [1],
            [1, 4, 5],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
        ];

        foreach ($matrix as $i => $outter) {
            foreach ($outter as $j => $inner) {
                Access::create([
                    'role_id' => $inner,
                    'komponen_id' => $komponenId[$i],
                ]);
            }
        }
    }
}
