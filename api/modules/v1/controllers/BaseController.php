<?php

namespace api\modules\v1\controllers;

use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\Response;

class BaseController extends ActiveController
{
    public $modelClass = '';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => [
                        'http://localhost',
                        // add another site for allow enable CORS
                    ],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    //'set-sync' => ['post'],
                ],
            ],
        ]);
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}