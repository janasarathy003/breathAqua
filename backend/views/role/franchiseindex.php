<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Franchise Roles';
//$this->params['breadcrumbs'][] = $this->title;
?>

     <div class="card-body">
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
               'template'=>'{update}{service-assign}',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
                'buttons'=>[
                  'view' => function ($url, $model, $key) {
                  
                       return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
                    }, 
                    
            'delete' => function ($url, $model, $key) {
              
                          $url=Url::base().'/role-d/'.$model->id;
                            
                           return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete' ]);
                        
                      },
                 'update' => function ($url, $model, $key) {
                    
                          
                            return Html::button('<i class="fa fa-edit"></i>', ['style'=>'margin-right:4px;','class' => 'btn btn-warning btn-xs', 'data-toggle'=>'quickview', 'title' =>'Update','data-target'=>"#role-manage",'data-url'=> Url::base(true)."/role-u/".$model->id]);
                        },
                        'service-assign' => function ($url, $model, $key) {
                    
                            $url=Url::base()."/role-manage-fc/".$model->id;
                            $options = array_merge([
                                            'class' => 'btn btn-success btn-xs update gridbtncustom',
                                             'data-provide' =>'tooltip','data-placement'=>'top','title'=>true,'data-original-title'=>'Rights Assign',
                                            
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                        ]);
                               
                                return Html::a('<span class="fa fa-plus"></span>', $url, $options);
                            //return Html::button('<i class="fa fa-edit"></i>', ['style'=>'margin-right:4px;','class' => 'btn btn-warning btn-xs', 'data-toggle'=>'quickview', 'title' =>'Update','data-target'=>"#role-manage",'data-url'=> Url::base(true)."/role-u/".$model->id]);
                        },
              ] ],
           // 'id',
            'role_name',
            ['attribute'=>'franchise_type',
              'headerOptions'=>['style'=>'color:#ba2967'],
            ],
           // 'role_description:ntext',
            ['attribute'=>'active_status',
             
            'value'=>function($models, $keys){
             

             if($models->active_status=="1"){

                return  "Active";
             }else if($models->active_status=="0"){
                return  "In Active";
             }
               
            },
            'filter'=>array('1'=>'Active','0'=>'In-Active'),
          ],
           // 'created_at',
            //'updated_at',
            //'ip_address',
            //'system_name',
            //'user_id',
            //'user_role',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
      <div id="role-manage" class="quickview quickview-xl backdrop-dark" data-fullscreen-on-mobile></div>
