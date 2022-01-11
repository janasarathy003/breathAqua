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
    <h4 class="page-title">User Management</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= Html::a('User Management', ['index'], ['class' => '' ]) ?></li>
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
                            <?= $form->field($model, 'userType')->dropDownList([ 'home' => 'Home',"company"=>"Company"], ['class'=>'form-control input-sm']) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control input-sm','placeholder'=>true]) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'phoneNo')->textInput(['maxlength' => 10,'class'=>'form-control input-sm','placeholder'=>true,'onkeypress'=>'return isNumberKey(event)']) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'alternatePhoneNo')->textInput(['maxlength' => 10,'class'=>'form-control input-sm','placeholder'=>true,'onkeypress'=>'return isNumberKey(event)']) ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'mailId')->textInput(['maxlength' => true,'class'=>'form-control input-sm','placeholder'=>true]) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'referalCode')->textInput(['maxlength' => true,'class'=>'form-control input-sm','placeholder'=>true]) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'blockNo')->textInput(['maxlength' => true,'class'=>'form-control input-sm','placeholder'=>true]) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'floorNo')->textInput(['maxlength' => true,'class'=>'form-control input-sm','placeholder'=>true]) ?>
                        </div>
                    </div>                                      
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'googleLocation')->textarea(['rows' => 4,'class'=>'form-control h-140','placeholder'=>true]) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'address')->textarea(['rows' => 4,'class'=>'form-control h-140','placeholder'=>true]) ?>
                        </div>
                    </div>  
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'detailedAddress')->textarea(['rows' => 4,'class'=>'form-control h-140','placeholder'=>true]) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><b>Delivery Frequency skills</b></label>
                            <?php

                                $sun = $mon = $tue = $wed = $thur = $fri = $sat = "";
                                $res = array();
                                if($model->deliveryFrequency!="" && $model->deliveryFrequency!=NULL){
                                    $res = json_decode($model->deliveryFrequency);
                                }

                                $dayAr = array('sun'=>'Sunday','mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thr'=>'Thursday','fri'=>'Friday','sat'=>'Saturday');

                                // echo "<pre>";print_r($dayAr);die;
                            ?>
                            <div class="selectgroup selectgroup-pills">
                                <?php foreach($dayAr as $shortKey => $day): 
                                        $isCheck = "";
                                        if(in_array($shortKey, $res))
                                            $isCheck = "checked";

                                    ?>
                                    <label class="selectgroup-item">
                                        <input type="checkbox" name="deliveryFrequency[]" value="<?php echo $shortKey; ?>" class="selectgroup-input" <?php echo $isCheck; ?> ><span class="selectgroup-button"><?php echo $day; ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'noOfCansPerVisit')->textInput(['maxlength' => true,'class'=>'form-control input-sm','placeholder'=>true,'onkeypress'=>'return isNumberKey(event)']) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'noOfCansDeposite')->textInput(['maxlength' => true,'class'=>'form-control input-sm','placeholder'=>true,'onkeypress'=>'return isNumberKey(event)']) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <?= $form->field($model, 'userPrice')->textInput(['maxlength' => true,'class'=>'form-control text-right input-sm','placeholder'=>true,'onkeypress'=>'return isNumberKey(event)' ]) ?>
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
                    <?= Html::a('<i class="fa fa-close"></i> Close', ['index'], ['class' => 'btn btn-outline-primary ','title'=>'Close'])?>

                    <?= Html::submitButton('Save', ['class' => 'btn btn-success ']) ?>
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