<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DepositeManagement */

$this->title = Yii::t('app', 'Create Deposite Management');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Deposite Managements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposite-management-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
