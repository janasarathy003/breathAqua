<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CapacityMaster */

$this->title = Yii::t('app', 'Create Capacity Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Capacity Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="capacity-master-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
