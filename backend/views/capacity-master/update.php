<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CapacityMaster */

$this->title = Yii::t('app', 'Update Capacity Master: {nameAttribute}', [
    'nameAttribute' => $model->capacityId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Capacity Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->capacityId, 'url' => ['view', 'id' => $model->capacityId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="capacity-master-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
