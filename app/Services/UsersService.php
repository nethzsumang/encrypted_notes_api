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
                'user' => $user
            ]);
        }
        return response()->json([
            'error' => 'User not found.'
        ], 404);
    }

    final public function createUser(array $data) : JsonResponse
    { logger($data);
        $response = (new UsersRepository)->createUser($data); logger($response);
        if (is_array($response) && !empty($response)) {
            return response()->json([
                'user' => $response
            ]);
        }
        return response()->json([
            'error' => 'User not created.'
        ], 500);
    }
}