<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RoleManageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role Manages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-manage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Role Manage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'role_id',
            'role_rights:ntext',
            'active_status',
            'created_at',
            //'updated_at',
            //'ip_address',
            //'system_name',
            //'user_id',
            //'user_role',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
