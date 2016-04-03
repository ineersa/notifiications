<?php

namespace app\modules\admin\models;

use app\events\ArticleEvent;
use app\events\UserEvent;
use app\modules\main\models\BrowserQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
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
 * @property array $type
 *
 * @property User $fromUser
 * @property User $toUser
 */
class Notifications extends ActiveRecord
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

    public function getTypes()
    {
        $value = $this->type;
        $html = '';
        if (!empty($value))
            foreach($value as $type){
                $html .= Html::tag('span', Html::encode(Notifications::getTypeById($type)), ['class' => 'label label-success']);
            }

        return $html;
    }

    public static function getUserEventsNotifications()
    {
        $events = UserEvent::getEvents();
        return self::find()
            ->where(['event'=>array_keys($events)])
            //->with(['fromUser'])
            ->all();
    }

    public static function getArticleEventsNotifications()
    {
        $events = ArticleEvent::getEvents();
        return self::find()
            ->where(['event'=>array_keys($events)])
            //->with(['fromUser'])
            ->all();
    }

    /**
     * @param $model User|Articles
     * @param $tokens
     */
    public function sendEmailNotification($model, $tokens)
    {
        $this->prepareTexts($model, $tokens);
        if ($this->to == 0){
            $userIds = Yii::$app->authManager->getUserIdsByRole('user');
            $users = User::find()
                ->where(['id'=>$userIds])
                ->andWhere(['status'=>User::STATUS_ACTIVE])
                ->all();

        } else {
            $users = User::find()
                ->where(['id'=>$this->to])
                ->all();
        }

        if (!empty($users)) {
            /**
             * @var $to User
             */
            foreach ($users as $to) {
                \Yii::$app->mailer
                    ->compose(
                        ['html' => '@app/modules/admin/mails/notification'],
                        ['text' => $this->text]
                    )
                    ->setFrom($this->fromUser->email)
                    ->setTo($to->email)
                    ->setSubject($this->notification_title)
                    ->send();
            }

        }

    }

    /**
     * @param $model User|Articles
     * @param $tokens
     */
    public function prepareTexts($model,$tokens)
    {
        foreach($tokens as $token=>$value){
            if ($model->hasAttribute($value)){
                $this->notification_title = str_ireplace($token,$model->getAttribute($value),$this->notification_title);
                $this->text = str_ireplace($token,$model->getAttribute($value),$this->text);
            } else {
                $this->notification_title = str_ireplace($token,$value,$this->notification_title);
                $this->text = str_ireplace($token,$value,$this->text);
            }
        }
    }

    /**
     * @param $model
     * @param $tokens
     * @return bool
     */
    public function addToBrowserQuery($model,$tokens)
    {
        $this->prepareTexts($model, $tokens);
        $browserQuery = new BrowserQuery();
        $browserQuery->notification_id = $this->id;
        $browserQuery->notification_title = $this->notification_title;
        $browserQuery->text = $this->text;

        return $browserQuery->save();
    }
}
