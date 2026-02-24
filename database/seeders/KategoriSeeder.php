<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Gadget', 'icon_svg' => '📱'],
            ['nama_kategori' => 'Kendaraan', 'icon_svg' => '🏍️'],
            ['nama_kategori' => 'Pendidikan', 'icon_svg' => '🎓'],
            ['nama_kategori' => 'Liburan', 'icon_svg' => '🏖️'],
            ['nama_kategori' => 'Properti', 'icon_svg' => '🏠'],
            ['nama_kategori' => 'Lainnya', 'icon_svg' => '✨'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}