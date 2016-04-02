<?php

use app\components\grid\ActionColumn;
use app\modules\admin\models\Articles;
use app\modules\admin\models\Notifications;
use app\modules\admin\models\User;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\NotificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Notifications');
$this->params['breadcrumbs'][] = $this->title;
$userFilter = User::getUsers();
?>
<div class="notifications-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Notifications'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => ['format' => 'yyyy-mm-dd']
                ]),
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Notifications $model */
                    return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                }
            ],
            'event',
            [
                'filter' => $userFilter,
                'attribute' => 'from',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return $model->fromUser->username;
                }
            ],
            [
                'filter' => [0=>Yii::t('app','ALL_USERS')] + $userFilter,
                'attribute' => 'to',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->to == 0)
                        return Yii::t('app','ALL_USERS');
                    else
                        return $model->toUser->username;
                }
            ],
            [
                'filter' => Notifications::$_types,
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    $value = $model->{$column->attribute};
                    $html = '';
                    if (!empty($value))
                        foreach($value as $type){
                            $html .= Html::tag('span', Html::encode(Notifications::getTypeById($type)), ['class' => 'label label-success']);
                        }

                    return $html === '' ? $column->grid->emptyCell : $html;
                }
            ],

            ['class' => ActionColumn::className()],
        ],
    ]); ?>
</div>
