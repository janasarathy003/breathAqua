<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DepositeManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deposite-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'autoId') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'noOfCanDeposite') ?>

    <?= $form->field($model, 'isDeposite') ?>

    <?= $form->field($model, 'depositeAmount') ?>

    <?php // echo $form->field($model, 'isReturn') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
