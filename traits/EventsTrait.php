<?php

namespace app\traits;

use app\events\UserEvent;
use app\modules\user\models\User;

trait EventsTrait
{
    /**
     * @param  User      $user
     * @return UserEvent
     * @throws \yii\base\InvalidConfigException
     */
    protected function getUserEvent(User $user)
    {
        return \Yii::createObject(['class' => UserEvent::className(), 'user' => $user]);
    }
}