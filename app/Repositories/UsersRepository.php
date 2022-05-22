<?php
namespace App\Repositories;

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
}