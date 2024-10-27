<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\UserService;

class UserController
{
    public function store(Request $request, Response $response)
    {
        $body = $request::body();

        $userService = UserService::create($body);

        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        $response::json([
            'error' => false,
            'sucess' => true,
            'data' => $userService
        ], 201);
    }

    public function login(Request $request, Response $response)
    {
        $body = $request::body();

        $userService = UserService::auth($body);

        if (isset($userService['error'])) {
            return $response::json([
                'error' => true,
                'success' => false,
                'message' => $userService['error']
            ], 400);
        }

        $response::json([
            'error' => false,
            'sucess' => true,
            'jwt' => $userService
        ], 200);
        return;
    }

    public function fetch(Request $request, Response $response)
    {

    }

    public function update(Request $request, Response $response)
    {

    }

    public function remove(Request $request, Response $response, array $id)
    {

    }
}