<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BrandMaster */

$this->title = Yii::t('app', 'Update Brand Master: {nameAttribute}', [
    'nameAttribute' => $model->brandId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Brand Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->brandId, 'url' => ['view', 'id' => $model->brandId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="brand-master-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
