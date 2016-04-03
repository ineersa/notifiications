<?php

namespace app\modules\main\models;

use app\modules\admin\models\Notifications;
use app\modules\admin\models\User;
use Yii;

/**
 * This is the model class for table "browser_query_read".
 *
 * @property integer $id
 * @property integer $notification_id
 * @property integer $user_id
 *
 * @property Notifications $notification
 * @property User $user
 */
class BrowserQueryRead extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'browser_query_read';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_id', 'user_id'], 'required'],
            [['notification_id', 'user_id'], 'integer'],
            [['notification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notifications::className(), 'targetAttribute' => ['notification_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'notification_id' => Yii::t('app', 'Notification ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(Notifications::className(), ['id' => 'notification_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
