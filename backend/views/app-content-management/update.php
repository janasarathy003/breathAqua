<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AppContentManagement */

$this->title = Yii::t('app', 'Update App Content Management: {nameAttribute}', [
    'nameAttribute' => $model->autoId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'App Content Managements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->autoId, 'url' => ['view', 'id' => $model->autoId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="app-content-management-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
