<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SmsLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sms-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createddate')->textInput() ?>

    <?= $form->field($model, 'modifieddate')->textInput() ?>

    <?= $form->field($model, 'updatedipaddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'responselog')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
