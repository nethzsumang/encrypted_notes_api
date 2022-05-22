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
     * Get user id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserId(Request $request)
    {
        $username = $request->get('username', '');
        return (new UsersService)->getUserId($username);
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
