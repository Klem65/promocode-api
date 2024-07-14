<?php
namespace app\commands;

use app\services\UserService;
use yii\console\Controller;
use yii\console\ExitCode;

class CreateUserController extends Controller
{
    public function actionAdd($username)
    {
        $userService = new UserService();
        $result = $userService->createUserWithPromocode($username);

        if ($result['success']) {
            echo "User '{$result['username']}' has been added.\n";
            echo "Token: '{$result['token']}'.\n";
            return ExitCode::OK;
        } else {
            echo $result['message'] . "\n";
            if (isset($result['errors'])) {
                foreach ($result['errors'] as $errors) {
                    foreach ($errors as $error) {
                        echo "{$error}\n";
                    }
                }
            }
            return ExitCode::DATAERR;
        }
    }
}