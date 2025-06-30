<?php

namespace Database\Seeders;

use App\Models\Dialog;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Dialog::create([
            'id' => 1,
            'message' => "Silahkan pilih kategori layanan yang sesuai dengan kebutuhan Anda dengan mengetikan Angka pada kategori di bawah ini :\n1. Pertanyaan Keterjaminan Korban\n2. Support oleh Petugas Jasa Raharja",
            'step' => 0,
            'parent_id' => null,
        ]);

        Dialog::create([
            'id' => 2,
            'message' => "Silahkan pilih category terkait support oleh Petugas Jasa Raharja, sebagai berikut :\n1. Terbit Surat Jaminan (Guarantee Letter)\n2. Penyelesaian permasalahan oleh Petugas Jasa Raharja",
            'step' => 2,
            'parent_id' => 1,

        ]);

        Dialog::create([
            'id' => 3,
            'message' => "Permasalahan apa yang ingin di bantu oleh kami : \n 1. Lainnya",
            'step' => 1,
            'parent_id' => 2,
        ]);

        Dialog::create([
            'id' => 4,
            'message' => "Lainnya \n 1. Bantuan Petugas",
            'step' => 1,
            'parent_id' => 3,
        ]);
        User::create([
            'email' => 'rapi@gmail.com',
            'name' => 'Rapi',
            'password' => bcrypt('12345678'),
        ]);
    }
}
