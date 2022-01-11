<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductMaster */

$this->title = Yii::t('app', 'Create Product Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Masters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-master-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
