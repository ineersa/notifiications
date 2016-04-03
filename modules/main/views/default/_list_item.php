<?php

use app\modules\main\models\BrowserQuery;
use yii\bootstrap\Alert;

/**
 * @var $model BrowserQuery
 */
?>

<?php
Alert::begin([
    'options' => [
        'class' => 'alert-info',
    ],
    'closeButton' => [
        'onclick' => 'setRead('.$model->notification->id.','.\Yii::$app->user->id.')'
    ],
]);
?>
<b><?=$model->notification_title;?></b><br/>
<?=$model->text;?>
<?php
Alert::end();
?>