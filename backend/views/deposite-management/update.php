<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DepositeManagement */

$this->title = Yii::t('app', 'Update Deposite Management: {nameAttribute}', [
    'nameAttribute' => $model->autoId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposite Managements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->autoId, 'url' => ['view', 'id' => $model->autoId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="deposite-management-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
