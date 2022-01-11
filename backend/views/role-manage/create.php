<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\RoleManage */

$this->title = 'Create Role Manage';
$this->params['breadcrumbs'][] = ['label' => 'Role Manages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-manage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
