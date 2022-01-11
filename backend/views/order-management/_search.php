<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderManagementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-management-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'orderId') ?>

    <?= $form->field($model, 'orderCode') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'prouductId') ?>

    <?= $form->field($model, 'orderedQuantity') ?>

    <?php // echo $form->field($model, 'isDelivered') ?>

    <?php // echo $form->field($model, 'deliveredQuantity') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
