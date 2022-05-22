<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Libraries\EncryptionLibrary;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get user record
        $user = DB::table('users')
            ->where('username', 'admin')
            ->first();
        
        $k1 = EncryptionLibrary::getKey('admin', $user->salt, $user->k1);

        $title = EncryptionLibrary::encryptContent('First Note', $k1, $user->iv);
        $content = EncryptionLibrary::encryptContent('Hello, World!', $k1, $user->iv);

        DB::table('notes')->insert([
            'user_id' => $user->id,
            'title' => $title,
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
