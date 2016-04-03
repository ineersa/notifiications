<?php

namespace app\modules\main\models;

use app\modules\admin\models\Notifications;
use Yii;

/**
 * This is the model class for table "browser_query".
 *
 * @property integer $id
 * @property integer $notification_id
 * @property string $notification_title
 * @property string $text
 *
 * @property Notifications $notification
 */
class BrowserQuery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'browser_query';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_id', 'notification_title', 'text'], 'required'],
            [['notification_id'], 'integer'],
            [['text'], 'string'],
            [['notification_title'], 'string', 'max' => 255],
            [['notification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notifications::className(), 'targetAttribute' => ['notification_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notification_id' => 'Notification ID',
            'notification_title' => 'Notification Title',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(Notifications::className(), ['id' => 'notification_id']);
    }
}
