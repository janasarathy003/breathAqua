<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'productId') ?>

    <?= $form->field($model, 'productName') ?>

    <?= $form->field($model, 'capacityId') ?>

    <?= $form->field($model, 'capacity') ?>

    <?= $form->field($model, 'brandId') ?>

    <?php // echo $form->field($model, 'brandName') ?>

    <?php // echo $form->field($model, 'basePrice') ?>

    <?php // echo $form->field($model, 'halfPrice') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
