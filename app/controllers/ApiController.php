<?php

namespace app\controllers;

use app\services\UserService;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'create' => ['post'],
                'promocode' => ['get'],
            ],
        ];
        return $behaviors;
    }

    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isPost) {
            Yii::$app->response->statusCode = 405;
            return [
                'success' => false,
                'message' => Yii::$app->params['notAvailableMethodMessage'],
                'errors' => 405,
            ];
        }

        $username = Yii::$app->request->post('username');
        $userService = new UserService();
        return $userService->createUserWithPromocode($username);
    }

    public function actionPromocode(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userService = new UserService();

        return $userService->getPromocodeByToken(Yii::$app->request->getHeaders()['authorization']);
    }

}
