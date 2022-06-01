<?php
namespace App\Services;

use App\Repositories\UsersRepository;
use Illuminate\Http\JsonResponse;

/**
 * Class UsersService
 * @package App\Services
 */
class UsersService
{
    /**
     * Get user 
     * @param string $username
     * @return JsonResponse
     */
    final public function getUser(string $username) : JsonResponse
    {
        $user = (new UsersRepository)->getUser($username);
        if ($user) {
            return response()->json([
                'user_id' => $user
            ]);
        }
        return response()->json([
            'error' => 'User not found.'
        ], 404);
    }
}