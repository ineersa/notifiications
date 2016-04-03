<?php

namespace app\traits;

use app\events\ArticleEvent;
use app\events\UserEvent;
use app\modules\admin\models\Articles;
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

    /**
     * @param  Articles      $articles
     * @return ArticleEvent
     * @throws \yii\base\InvalidConfigException
     */
    protected function getArticleEvent(Articles $articles)
    {
        return \Yii::createObject(['class' => ArticleEvent::className(), 'article' => $articles]);
    }
}