<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CompanyUsersList */

$this->title = Yii::t('app', 'Update Company Users List: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Company Users Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->autoId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="company-users-list-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
