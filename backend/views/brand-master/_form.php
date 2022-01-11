<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\LeftmenuManagement */
/* @var $form yii\widgets\ActiveForm */
?>
 <!-- <div class="leftmenu-management-form"> -->
     
<div class="page-header">
    <h4 class="page-title">Brand Master</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Html::a('Brand Master', ['index'], ['class' => '' ]) ?></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card  ">
           <?php $form = ActiveForm::begin(); ?>
            <div class="card-body">              
                <div class="form-row">
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'brandName')->textInput(['maxlength' => true,'class'=>'form-control input-sm','placeholder'=>true]) ?>
                        </div>
                    </div>
                    
                    <div class=" col-md-3">
                        <div>
                            <?php
                                $acSt = 'A';
                                if($model->status!=""&&$model->status!=NULL){
                                    $acSt = $model->status;
                                }
                                ?>
                            <?= $form->field($model, 'status')->dropDownList([ 'A' => 'Active', 'I' => 'InActive', ], ['class'=>'form-control input-sm','value'=>$acSt]) ?>
                        </div>
                    </div> 
                </div>   
            </div>
            <div class="card-footer">
                   <div class="text-right">
                    <?= Html::a('<i class="fa fa-close"></i> Close', ['index'], ['class' => 'btn btn-outline-primary btn-sm ','title'=>'Close'])?>

                    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']) ?>
                </div>
                
                </div>
                <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function isNumberKey(evt) {
        var charCode = evt.which ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) return false;

        return true;
    }
</script>