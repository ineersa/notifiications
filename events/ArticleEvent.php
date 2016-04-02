<?php

namespace app\events;
use app\modules\admin\models\Articles;
use yii\base\Event;

/**
 * @property Articles $model
 */
class ArticleEvent extends Event
{
    const ARTICLE_CREATED = 'articleCreated';
    const ARTICLE_UPDATED = 'articleUpdated';

    /**
     * @var Articles
     */
    private $_article;
    /**
     * @return Articles
     */
    public function getArticle()
    {
        return $this->_article;
    }
    /**
     * @param Articles $form
     */
    public function setArticle(Articles $form)
    {
        $this->_article = $form;
    }

    public static function getEvents()
    {
        return [
            self::ARTICLE_CREATED => self::ARTICLE_CREATED,
            self::ARTICLE_UPDATED => self::ARTICLE_UPDATED
        ];
    }
}