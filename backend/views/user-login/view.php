<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserLogin */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Logins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-login-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'master_type',
            'name',
            'contactNumber',
            'emailId:email',
            'address:ntext',
            'profileImage:ntext',
            'roleId',
            'role',
            'login_id',
            'franchise_id',
            'username',
            'staff_name',
            'auth_key:ntext',
            'password:ntext',
            'role_type',
            'dept_id',
            'is_active',
            'created_at',
            'updated_at',
            'ip_address',
            'system_name',
            'user_id',
            'user_role',
        ],
    ]) ?>

</div>
