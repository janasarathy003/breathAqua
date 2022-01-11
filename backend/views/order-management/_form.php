<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\UserManagement;
use backend\models\ProductMaster;
/* @var $this yii\web\View */
/* @var $model backend\models\LeftmenuManagement */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="page-header">
    <h4 class="page-title">Order Management</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Html::a('Order Management', ['index'], ['class' => '' ]) ?></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card  ">
           <?php $form = ActiveForm::begin(); ?>
            <div class="card-body">              
                <div class="form-row">
                    <div class="col-md-4">
                        <div>
                            <?php 
                                $inAr = ArrayHelper::map(UserManagement::find()->where(['status'=>'A'])->asArray()->all(),'userId','name');
                            ?>
                            <?= $form->field($model, 'userId')->dropDownList($inAr, ['class'=>'form-control input-sm','prompt'=>'Select User..']) ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <?php 
                                $inAr = ArrayHelper::map(ProductMaster::find()->where(['status'=>'A'])->asArray()->all(),'prouductId','productName');
                            ?>
                            <?= $form->field($model, 'prouductId')->dropDownList($inAr, ['class'=>'form-control input-sm','prompt'=>'Select Product..']) ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <?= $form->field($model, 'orderedQuantity')->textInput(['maxlength' => true,'class'=>'form-control input-sm','placeholder'=>true,'onkeypress'=>'return isNumberKey(event)']) ?>
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