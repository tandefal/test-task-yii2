<?php

namespace app\api\controllers;

use app\models\Message;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class MessageController extends \yii\rest\Controller
{
    /**
     * @return string[]
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionMessage()
    {
        $model = new Message(['scenario' => 'api']);
        $model->load(\Yii::$app->request->getBodyParams(), '');

        if ($model->validate()) {
            if ($model->save()) {
                \Yii::$app->response->statusCode = 201;
                return ['status' => 'success', 'message' => 'Message saved successfully.'];
            } else {
                throw new ServerErrorHttpException('Failed to save message.');
            }
        } else {
            \Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException(json_encode($model->errors));
        }
    }
}