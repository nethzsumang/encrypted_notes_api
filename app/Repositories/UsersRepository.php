<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class NotesRepository
 * @package App\Repositories
 */
class UsersRepository
{
    /**
     * Get user
     * @param string $username
     * @return mixed
     */
    public function getUser(string $username)
    {
        return DB::table('users')
            ->where('username', $username)
            ->first();
    }

    final public function createUser(array $data)
    {
        DB::table('users')->insert($data);
        return DB::table('users')->where('username', $data['username'])->first();
    }
}