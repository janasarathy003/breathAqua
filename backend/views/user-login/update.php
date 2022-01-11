<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserLogin */

$this->title = 'Update User Login';
// $this->params['breadcrumbs'][] = ['label' => 'User Logins', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<!-- <div class="user-login-update"> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<!-- </div> -->
