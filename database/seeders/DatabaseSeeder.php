<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Children;
use App\Models\DataCollection;
use App\Models\Folder;
use App\Models\Kelurahan;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $userKelurahan = User::create([
            'username' => 'usernameKelurahan',
            'password' => bcrypt('password'),
            'role' => 'kelurahan'
        ]);
        $userPosyandu = User::create([
            'username' => 'usernamePosyandu',
            'password' => bcrypt('password'),
            'role' => 'posyandu'
        ]);
        $userPuskesmas = User::create([
            'username' => 'usernamePuskesmas',
            'password' => bcrypt('password'),
            'role' => 'puskesmas'
        ]);
        $kelurahan = Kelurahan::create([
            'user_id' => $userKelurahan->id,
            'nama' => 'Kelurahan Sendangsari',
            'alamat' => 'Pengasih, Kulon Progo',
        ]);
        $posyandu = Posyandu::create([
            'user_id' => $userPosyandu->id,
            'nama' => 'User Posyandu',
            'alamat_padukuhan' => 'padukuhan 1'
        ]);
        $puskesmas = Puskesmas::create([
            'user_id' => $userPuskesmas->id,
            'nama' => 'User Puskesmas',
        ]);
        $folder = Folder::create([
            'nama' => 'Januari',
            'tanggal' => Carbon::parse('2000-01-01'),
        ]);
        $children = Children::create([
            'posyandu_id' => $posyandu->id,
            'nama' => 'John Lark',
            'tgl_lahir' => Carbon::parse('2000-01-01'),
            'jenis_kelamin' => 'laki-laki',
            'nik' => '1234567890123456',
            'kk' => '1234567890123456',
            'bb_lahir' => 3,
            'tb_lahir' => 30,
            'ibu_nama' => 'Nama Ibu',
            'ibu_nik' => '1234567890123456',
            'ibu_hp' => '1234567890',
            'alamat_padukuhan' => 'padukuhan 1',
            'alamat_rt' => 'rt 1',
            'alamat_rw' => 'rw 1',
            'active' => 1
        ]);
        DataCollection::create([
            'folder_id' => $folder->id,
            'children_id' => $children->id,
            'bb' => 4,
            'tb' => 35.5,
            'lika' => 10,
            'lila' => 6,
            'asi_eks' => 1,
            'pmba' => 0,
            'vit_a' => 0
        ]);
    }
}
