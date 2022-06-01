<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsersService;
use App\Services\NotesService;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * Get user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request)
    {
        $username = $request->get('username', '');
        return (new UsersService)->getUser($username);
    }

    /**
     * Get notes of user
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    final public function getAllNotesOfUser(int $userId)
    {
        return (new NotesService)->getAllNotesOfUser($userId);
    }
}
