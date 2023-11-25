<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $type_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $content
 * @property string $created_at
 */
class Message extends ActiveRecord
{
    const TYPE_API = 1;
    const TYPE_FRONTEND = 2;

    public function rules(): array
    {
        return [
            [['name', 'email', 'phone', 'content'], 'required'],
            [['name', 'email', 'phone'], 'string', 'max' => 255],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^\+\d\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/'],
            ['content', 'string', 'length' => [50, 1000]],
        ];
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $this->type_id = $this->determineMessageType();
            $this->created_at = Yii::$app->formatter->asDatetime(time());
            return true;
        }
        return false;
    }

    protected function determineMessageType(): int
    {
        return ($this->scenario === 'api') ? self::TYPE_API : self::TYPE_FRONTEND;
    }

}
