<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderManagement */

$this->title = Yii::t('app', 'Update Order Management: {nameAttribute}', [
    'nameAttribute' => $model->orderId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Managements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->orderId, 'url' => ['view', 'id' => $model->orderId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="order-management-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
