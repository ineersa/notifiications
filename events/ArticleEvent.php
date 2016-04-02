<?php

namespace app\events;
use app\modules\admin\models\Articles;

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
    public function getUser()
    {
        return $this->_article;
    }
    /**
     * @param Articles $form
     */
    public function setUser(Articles $form)
    {
        $this->_article = $form;
    }
}