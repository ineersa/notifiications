<?php

use app\modules\admin\models\Notifications;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Notifications */
/* @var $form yii\widgets\ActiveForm */
$users = \app\modules\admin\models\User::getUsers();
$events = [
    Yii::t('app','USER_EVENTS') => \app\events\UserEvent::getEvents(),
    Yii::t('app','ARTICLE_EVENTS') => \app\events\ArticleEvent::getEvents()
];
use \app\events\UserEvent;
use \app\events\ArticleEvent;
?>

<div class="notifications-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'event')->dropDownList($events) ?>

    <?= $form->field($model, 'from')->dropDownList($users) ?>

    <?= $form->field($model, 'to')->dropDownList([0=>Yii::t('app','ALL_USERS')] + $users) ?>

    <div class="tokens">
        <p>
            <?=\Yii::t('app','USER_TOKENS_AVAILABLE');?>
        <?php foreach(UserEvent::getTokensForView() as $token)
            echo $token . ' ';
        ?>
        </p>
        <p>
            <?=\Yii::t('app','ARTICLE_TOKENS_AVAILABLE');?>
            <?php foreach(ArticleEvent::getTokensForView() as $token)
                echo $token . ' ';
            ?>
        </p>
    </div>

    <?= $form->field($model, 'notification_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->dropDownList(Notifications::$_types,['multiple' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
