<?php
namespace app\services;

use app\models\Promocode;
use app\models\User;
use Exception;
use yii\base\Component;

class UserService extends Component
{
    public function createUserWithPromocode($username): array
    {
        $user = new User();
        $user->username = $username;

        try {
            if ($user->save()) {
                $promocode = new Promocode();
                $promocode->user_id = $user->id;
                if ($promocode->save()) {
                    return [
                        'success' => true,
                        'username' => $user->username,
                        'token' => $user->access_token
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'User has been created, but promocode failed.',
                        'user_id' => $user->id,
                        'errors' => $promocode->errors,
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to add user.',
                    'errors' => $user->errors,
                ];
            }
        } catch (Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function getPromocodeByToken(?string $token): array
    {
        if (empty($token)) {
            return [
                'success' => false,
                'message' => 'Authorization token is empty. Promocode not find',
            ];
        }

        $user = User::findIdentityByAccessToken(explode(" ", $token)[1]);
        if (empty($user)) {
            return [
                'success' => false,
                'message' => 'User not find by token',
            ];
        }

        $promocode = Promocode::findIdentityByUser($user);
        if (empty($promocode)) {
            return [
                'success' => false,
                'message' => 'Promocode not find',
            ];
        }
        return [
            'success' => true,
            'user_id' => $user->id,
            'user_name' => $user->username,
            'code' => $promocode->code,
        ];
    }

}