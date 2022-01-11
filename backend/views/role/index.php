<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LeftmenuManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role Managements';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="leftmenu-management-index"> -->
<br>
<div class="row">
   <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header" >
				<h3 class="card-title">Role Management</h3>
		          <div class="card-options">
                <?= Html::a('<i class="fa fa-refresh"></i> Refresh', ['index'], ['class' => 'btn btn-outline-primary btn-sm  ' ]) ?>
                <?= Html::a('<i class="fa fa-plus"></i> Add', ['create'], ['class' => 'btn btn-addNew btn-sm ml-2 mr-2 ' ]) ?>
				</div>                 
            </div>
        
            <div class="card-body">
                <div class="table-responsive">
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                              'class' => 'yii\grid\SerialColumn'
                            ],
                            
                            'role_name',
                            [
                                'attribute'=>'active_status',
                                'value'=>function($models, $keys){
                                    if($models->active_status=="1"){
                                        return  "Active";
                                    }else if($models->active_status=="0"){
                                        return  "In Active";
                                    }    
                                },
                                'filter'=>array('1'=>'Active','0'=>'In-Active'),
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header'=> 'Action',
                                'template'=>'{update}{service-assign}{delete}',
                                'headerOptions' => ['style' => 'width:120px;color:#337ab7;'],
                                'buttons'=>[
                                    'view' => function ($url, $model, $key) {
                                        return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-sm view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
                                    }, 
                                    'delete' => function ($url, $model, $key) { 
                                        $sts = $model->active_status;
                                        $ar = array('1'=>'Active','0'=>'In Active');
                                        $ar_tog = array('1'=>'fa fa-check-circle-o fa-lg text-success','0'=>'fa fa-ban fa-lg text-danger');
                                        $title=$ar[$sts]; 
                                        $session = Yii::$app->session; 
                                        $url=Url::base().'/role-d/'.$model->id;
                                        $controler_url_id = Yii::$app -> controller -> id;
                                        return  Html::button('<i class="'.$ar_tog[$sts].'"></i>', ['value' => $url, 'class' => 'btn btn-outline-primary btn-sm delete gridbtncustom modalStatusChange', 'data-toggle'=>'tooltip', 'title' =>$title ]).'</div>';                                            
                                        
                                        // return Html::button('<i class="'.$ar_tog[$sts].'"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm delete gridbtncustom modalStatusChange', 'data-toggle'=>'tooltip', 'title' =>$title ]);                                            
                                    },
                                    'update' => function ($url, $model, $key) {
                                        $url=Url::base()."/role-u/".$model->id;
                                          $options = array_merge([
                                            'class' => 'btn btn-editNew btn-sm update gridbtncustom',
                                            'data-provide' =>'tooltip','data-placement'=>'top','title'=>true,'data-original-title'=>'Update',
                                                
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                            'data-toggle'=>'tooltip', 'title' =>'Update'
                                        ]);
                                   
                                        return '<div class="btn-group mb-1"> '. Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                    },
                                    'service-assign' => function ($url, $model, $key) {
                                        $url=Url::base()."/role-manage-c/".$model->id;$url=Url::base()."/role-manage-c/".$model->id;
                                        $options = array_merge([
                                            'class' => 'btn btn-viewNew btn-sm update ',
                                            'data-provide' =>'tooltip','data-placement'=>'top','title'=>true,'data-original-title'=>'Rights Assign',
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                            'data-toggle'=>'tooltip', 'title' =>'Manage Permissions'
                                        ]);
                                        return Html::a('<span class="fa fa-plus"></span>', $url, $options);
                                    },
                                ]
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
       
<!-- </div> -->