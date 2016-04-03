<?php

/* @var $this yii\web\View */
/* @var $dataProvider ActiveDataProvider */
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\web\JqueryAsset;

JqueryAsset::register($this);
$this->title = \Yii::$app->name;
?>

<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'tag' => 'div',
        'class' => 'list-wrapper',
        'id' => 'list-wrapper',
    ],
    'layout' => "{pager}\n{items}\n{summary}",
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_list_item',['model' => $model]);
    },
    'pager' => [
        'firstPageLabel' => \Yii::t('app','PAGER_FIRST'),
        'lastPageLabel' => \Yii::t('app','PAGER_LAST'),
        'nextPageLabel' => \Yii::t('app','PAGER_NEXT'),
        'prevPageLabel' => \Yii::t('app','PAGER_PREVIOUS'),
        'maxButtonCount' => 3,
    ],
]);
?>
<script>
    function setRead(notificationId,userId)
    {
        $.post('<?=Url::to('/main/default/set-read');?>',{notificationId:notificationId,userId:userId},function(data){
            window.location.reload();
        });
    }
</script>