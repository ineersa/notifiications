<?php

namespace app\modules\admin\models;

use app\traits\EventsHandlersTrait;
use app\traits\EventsTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $sitename
 * @property string $article_name
 * @property string $text
 */
class Articles extends \yii\db\ActiveRecord
{

    use EventsTrait;
    use EventsHandlersTrait;

    public function init()
    {
        parent::init();
        $this->initArticleHandlers($this);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sitename', 'article_name', 'text'], 'required'],
            [['text'], 'string'],
            [['sitename', 'article_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'sitename' => Yii::t('app', 'Sitename'),
            'article_name' => Yii::t('app', 'Article Name'),
            'text' => Yii::t('app', 'Text'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $event = $this->getArticleEvent($this);
        if ($insert){
            $this->trigger($event::ARTICLE_CREATED,$event);
        } else $this->trigger($event::ARTICLE_UPDATED,$event);
    }
}
