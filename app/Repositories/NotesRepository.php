<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * Class NotesRepository
 * @package App\Repositories
 */
class NotesRepository
{
    /**
     * Get all notes of user
     * @param int $userId
     */
    public function getAllNotesOfUser(int $userId)
    {
        $notes = DB::table('notes')
            ->where('user_id', $userId)
            ->get();
        return $notes;
    }
}