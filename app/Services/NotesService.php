<?php
namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Repositories\NotesRepository;

/**
 * Class NotesService
 * @package App\Services
 */
class NotesService
{
    /**
     * Get all notes of user
     * @param int $userId
     * @return JsonResponse
     */
    final public function getAllNotesOfUser(int $userId) : JsonResponse
    {
        $notes = (new NotesRepository)->getAllNotesOfUser($userId);
        if ($notes) {
            return response()->json([
                'notes' => $notes
            ]);
        }
        return response()->json([
            'error' => 'Notes not found.'
        ], 404);
    }
}