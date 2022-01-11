<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AppContentManagement */

$this->title = Yii::t('app', 'App Content');
?>
<div class="app-content-management-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
