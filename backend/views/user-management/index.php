<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LeftmenuManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users List';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="leftmenu-management-index"> -->
<br>
<div class="row">
   <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header" >
                <h3 class="card-title">User Management</h3>
                <div class="card-options">
                    <?= Html::a('<i class="fa fa-refresh"></i> Refresh', ['index'], ['class' => 'btn btn-outline-primary btn-sm  ' ]) ?>
                    <?= Html::a('<i class="fa fa-plus"></i> Add', ['create'], ['class' => 'btn btn-addNew btn-sm ml-2 mr-2 ' ]) ?>
                </div>                 
            </div>
        
            <div class="card-body">
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'userType',
                            'name',
                            'phoneNo',
                            'mailId',
                            'noOfCansPerVisit',
                            'noOfCansDeposite',
                            [
                                'attribute'=>'status',
                                'value'=>function($models, $keys){
                                    if($models->status=="A"){
                                        return  "Active";
                                    }else{
                                        return  "In Active";
                                    }    
                                },
                                // 'filter'=>array('1'=>'Active','0'=>'In-Active'),
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header'=> 'Action',
                                'template'=>'{update}{delete}',
                                'headerOptions' => ['style' => 'width:100px;color:#337ab7;'],
                                'buttons'=>[

                                    'delete' => function ($url, $model, $key) { 
                                        $sts = "1";
                                        if($model->status!="" && $model->status!=NULL){
                                            $sts = $model->status;
                                        }
                                        $ar = array('A'=>'Active','I'=>'In Active');
                                        $ar_tog = array('A'=>'fa fa-check-circle-o fa-lg text-success','I'=>'fa fa-ban fa-lg text-danger');
                                        $title=$ar[$sts]; 
                                        $session = Yii::$app->session; 
                                        $url=Url::base().'/user-d/'.$model->userId;
                                        $controler_url_id = Yii::$app->controller->id;
                                        return Html::button('<i class="'.$ar_tog[$sts].'"></i>', ['value' => $url, 'class' => 'btn btn-outline-primary btn-sm delete gridbtncustom modalStatusChange', 'data-toggle'=>'tooltip', 'title' =>$title ]).'</div>';                                            
                                    },
                                    'update' => function ($url, $model, $key) {
                                        $url=Url::base()."/user-u/".$model->userId;
                                          $options = array_merge([
                                            'class' => 'btn btn-editNew btn-sm update gridbtncustom',
                                            'data-provide' =>'tooltip','data-placement'=>'top','title'=>true,'data-original-title'=>'Update',
                                                
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                            'data-toggle'=>'tooltip', 'title' =>'Update'
                                        ]);
                                   
                                        return '<div class="btn-group mb-1"> '. Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                        
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