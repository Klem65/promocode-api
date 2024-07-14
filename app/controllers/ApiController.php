<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => HttpBearerAuth::class,
//        ];
//        return $behaviors;
//    }

    public function actionIndex(): string
    {
        return 'test';
    }

}
