<?php

namespace app\events;
use app\modules\admin\models\Articles;
use yii\base\Event;
use yii\helpers\Url;

/**
 * @property Articles $model
 */
class ArticleEvent extends Event implements EventInterface
{
    const ARTICLE_CREATED = 'articleCreated';
    const ARTICLE_UPDATED = 'articleUpdated';

    private $_tokens = [
        '{title}' => 'title',
        '{link}' => ''
    ];

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

    public function getModel()
    {
        return $this->getArticle();
    }

    public function getTokens()
    {
        $url = Url::to(['/admin/articles/view','id'=>$this->getArticle()->id],true);
        $this->_tokens['{link}'] = $url;
        return $this->_tokens;
    }

    public static function getEvents()
    {
        return [
            self::ARTICLE_CREATED => self::ARTICLE_CREATED,
            self::ARTICLE_UPDATED => self::ARTICLE_UPDATED
        ];
    }
}