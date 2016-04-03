<?php

namespace app\modules\main\controllers;

use app\modules\main\models\BrowserQuery;
use app\modules\main\models\BrowserQueryRead;
use app\modules\user\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `main` module
 */
class DefaultController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['index', 'set-read'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $subQuery = BrowserQueryRead::find()
            ->select('query_id')
            ->where(['user_id'=>\Yii::$app->user->id]);

        $query = BrowserQuery::find()
            ->joinWith(['notification'],false)
            ->where(['notifications.to'=>[0,\Yii::$app->user->id]])
            ->andWhere(['not in','browser_query.id',$subQuery])
            ->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionSetRead()
    {
        $read = new BrowserQueryRead();
        $read->query_id = \Yii::$app->request->post('queryId',0);
        $read->user_id = \Yii::$app->request->post('userId',0);
        $read->save();
    }
}
