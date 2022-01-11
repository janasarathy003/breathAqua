<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserManagement */

$this->title = Yii::t('app', 'User Management', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Managements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->userId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-management-update">
s
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
