<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CompanyUsersList */

$this->title = Yii::t('app', 'Create Company Users List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Company Users Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-users-list-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
