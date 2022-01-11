<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BrandMaster */

$this->title = Yii::t('app', 'Create Brand Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Brand Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-master-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
