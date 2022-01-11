<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OrderManagement */

$this->title = Yii::t('app', 'Create Order Management');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Order Managements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-management-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
