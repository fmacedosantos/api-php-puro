<?php

namespace App\Services;

use App\Utils\Validator;
use App\Models\User;

class UserService
{
    public static function create(array $data)
    {
        try {
            $fields = Validator::validate([
                'name'=> $data['name'] ?? '',
                'email'=> $data['email'] ?? '',
                'password'=> $data['password'] ?? ''
            ]);

            $fields['password'] = password_hash($fields['password'], PASSWORD_DEFAULT);

            $user = User::save($fields);

            if (!$user) {
                return ['error' => 'We couldn\'t create your account.'];
            }

            return "User created successfully!";

        } 
        catch (\PDOException $e) {

            if ($e->getCode() === 1049) {
                return ['error' => 'We couldn\'t connect to the database.'];
            }

            if ($e->getCode() === "23000") {
                return ['error' => 'User already exists.'];
            }

            return ['error' => $e->getMessage()];
        }
        catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function auth(array $data)
    {
        try {
            $fields = Validator::validate([
                'email'=> $data['email'] ?? '',
                'password'=> $data['password'] ?? ''
            ]);

            $user = User::authentication($fields);

            if (!$user) {
                return ['error' => 'We couldn\'t authenticate you.'];
            }

            return $user;
        } 
        catch (\PDOException $e) {

            if ($e->getCode() === 1049) {
                return ['error' => 'We couldn\'t connect to the database.'];
            }

            return ['error' => $e->getMessage()];
        }
        catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}