<?php

namespace app\frontend\controllers;

use app\models\Message;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class MessageController extends \yii\web\Controller
{
    /**
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionMessage()
    {
        $model = new Message(['scenario' => 'frontend']);
        $model->load(\Yii::$app->request->post(), '');

        if ($model->validate()) {
            if ($model->save()) {
                \Yii::$app->response->statusCode = 201;
                return $this->asJson(['status' => 'success', 'message' => 'Message saved successfully.']);
            } else {
                throw new ServerErrorHttpException('Failed to save message.');
            }
        } else {
            \Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException(json_encode($model->errors));
        }
    }
}