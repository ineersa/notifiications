<?php

namespace app\modules\main\models;

use app\modules\admin\models\User;
use Yii;

/**
 * This is the model class for table "browser_query_read".
 *
 * @property integer $id
 * @property integer $query_id
 * @property integer $user_id
 *
 * @property BrowserQuery $query
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
            [['query_id', 'user_id'], 'required'],
            [['query_id', 'user_id'], 'integer'],
            [['query_id'], 'exist', 'skipOnError' => true, 'targetClass' => BrowserQuery::className(), 'targetAttribute' => ['query_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'query_id' => 'Query ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        return $this->hasOne(BrowserQuery::className(), ['id' => 'query_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
