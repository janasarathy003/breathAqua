<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductMaster */

$this->title = Yii::t('app', 'Update Product Master: {nameAttribute}', [
    'nameAttribute' => $model->productId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->productId, 'url' => ['view', 'id' => $model->productId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-master-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
