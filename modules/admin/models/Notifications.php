<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "notifications".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $title
 * @property string $event
 * @property integer $from
 * @property integer $to
 * @property string $notification_title
 * @property string $text
 * @property string $type
 *
 * @property User $from0
 * @property User $to0
 */
class Notifications extends \yii\db\ActiveRecord
{

    static $_types = [
        1 => 'email',
        2 => 'browser'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifications';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->type = implode(',',$this->type);
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        $this->type = explode(',',$this->type);

        parent::afterFind();
    }

    public static function getTypeById($id)
    {
        return (isset(static::$_types[$id])?static::$_types[$id]:'');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'event', 'from', 'to', 'notification_title', 'text', 'type'], 'required'],
            [['from', 'to'], 'integer'],
            [['text'], 'string'],
            [['type'], 'each', 'rule' => ['integer']],
            [['title', 'event', 'notification_title'], 'string', 'max' => 255],
            [['from'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from' => 'id']],
            //[['to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to' => 'id']],
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
            'title' => Yii::t('app', 'Title'),
            'event' => Yii::t('app', 'Event'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'notification_title' => Yii::t('app', 'Notification Title'),
            'text' => Yii::t('app', 'Text'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to']);
    }

    public function getTypes(){
        $value = $this->type;
        $html = '';
        if (!empty($value))
            foreach($value as $type){
                $html .= Html::tag('span', Html::encode(Notifications::getTypeById($type)), ['class' => 'label label-success']);
            }

        return $html;
    }
}
