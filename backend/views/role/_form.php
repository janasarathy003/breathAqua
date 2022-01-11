<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-header">
        <h4 class="page-title">Role Management</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><?= Html::a('Role Management', ['index'], ['class' => '' ]) ?></li>
            <li class="breadcrumb-item active" aria-current="page">Form #</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card  ">
         <?php $form = ActiveForm::begin(); ?>
                <div class="card-body">
                  
                    <div class="form-row">
                        <div class="col-md-5">
                            <div>
                                <?= $form->field($model, 'role_name')->textInput(['maxlength' => true,'autofocus'=>true,'data-bv-notempty'=>true,'rows'=>3,'data-bv-notempty-message'=>'Role Name Is Required and Cannot be Empty']) ?>
                                <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div>
                                <?= $form->field($model, 'role_description')->textarea(['maxlength' => true]) ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div>
                                <?php
                                    $acSt = '1';
                                    if($model->active_status!=""&&$model->active_status!=NULL){
                                        $acSt = $model->active_status;
                                    }
                                    ?>
                                <?= $form->field($model, 'active_status')->dropDownList([ '1' => 'Active', '0' => 'InActive', ], ['value'=>$acSt]) ?>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="card-footer">
               <div class="text-right">
                        <?= Html::a('<i class="fa fa-close"></i> Close', ['index'], ['class' => 'btn btn-outline-primary ','title'=>'Close'])?>

                        <?= Html::submitButton('Save', ['class' => 'btn btn-saveNew']) ?>
                    </div>
                    
          </div>
          <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>