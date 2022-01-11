<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserManagement */

$this->title = Yii::t('app', 'User Management');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Managements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-management-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
