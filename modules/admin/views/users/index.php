<?php

use app\modules\admin\models\User;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use app\components\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ADMIN_USERS');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ADMIN'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'username',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var User $model */
                    return Html::a(Html::encode($model->username), ['view', 'id' => $model->id]);
                }
            ],
            'email:email',
            [
                'filter' => User::getStatusesArray(),
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var User $model */
                    /** @var \yii\grid\DataColumn $column */
                    $value = $model->{$column->attribute};
                    switch ($value) {
                        case User::STATUS_ACTIVE:
                            $class = 'success';
                            break;
                        case User::STATUS_WAIT:
                            $class = 'warning';
                            break;
                        case User::STATUS_BLOCKED:
                        default:
                            $class = 'default';
                    };
                    $html = Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'label label-' . $class]);
                    return $value === null ? $column->grid->emptyCell : $html;
                }
            ],
            ['class' => ActionColumn::className()],
        ],
    ]); ?>
</div>
