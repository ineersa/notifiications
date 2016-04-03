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

    protected static $_tokens = [
        '{title}' => 'article_name',
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
        $tokens = static::$_tokens;
        $url = Url::to(['/admin/articles/view','id'=>$this->getArticle()->id],true);
        $tokens['{link}'] = $url;
        return $tokens;
    }

    public static function getEvents()
    {
        return [
            self::ARTICLE_CREATED => self::ARTICLE_CREATED,
            self::ARTICLE_UPDATED => self::ARTICLE_UPDATED
        ];
    }

    public static function getTokensForView()
    {
        return array_keys(static::$_tokens);
    }
}