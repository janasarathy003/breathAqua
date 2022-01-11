<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserManagement */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Managements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-management-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->userId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->userId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'userId',
            'userType',
            'name',
            'phoneNo',
            'alternatePhoneNo',
            'mailId',
            'referalCode',
            'googleLocation',
            'address:ntext',
            'blockNo',
            'floorNo',
            'detailedAddress:ntext',
            'deliveryFrequency:ntext',
            'noOfCansPerVisit',
            'noOfCansDeposite',
            'userPrice',
            'status',
            'createdAt',
            'updatedAt',
        ],
    ]) ?>

</div>
