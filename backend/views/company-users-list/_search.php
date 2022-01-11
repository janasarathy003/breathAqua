<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CompanyUsersListSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-users-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'autoId') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'phoneNo') ?>

    <?= $form->field($model, 'alternatePhoneNo') ?>

    <?php // echo $form->field($model, 'mailId') ?>

    <?php // echo $form->field($model, 'blockNo') ?>

    <?php // echo $form->field($model, 'floorNo') ?>

    <?php // echo $form->field($model, 'departmentName') ?>

    <?php // echo $form->field($model, 'designationName') ?>

    <?php // echo $form->field($model, 'detailedAddress') ?>

    <?php // echo $form->field($model, 'deliveryFrequency') ?>

    <?php // echo $form->field($model, 'noOfCansPerVisit') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
