<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Libraries\EncryptionLibrary;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keys = EncryptionLibrary::generateKeys('password');

        DB::table('users')->insert([
            'username' => 'admin',
            'email' => null,
            'salt' => $keys['salt'],
            'k1' => $keys['k1'],
            'iv' => $keys['iv']
        ]);
    }
}
