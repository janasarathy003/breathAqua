<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserLoginSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-login-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'master_type') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'contactNumber') ?>

    <?= $form->field($model, 'emailId') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'profileImage') ?>

    <?php // echo $form->field($model, 'roleId') ?>

    <?php // echo $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'login_id') ?>

    <?php // echo $form->field($model, 'franchise_id') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'staff_name') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'role_type') ?>

    <?php // echo $form->field($model, 'dept_id') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'ip_address') ?>

    <?php // echo $form->field($model, 'system_name') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'user_role') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
