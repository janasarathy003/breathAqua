<?php
  use yii\helpers\Url;
  use yii\helpers\Html;
  use yii\helpers\ArrayHelper;
  use yii\widgets\ActiveForm;
  use backend\models\Role;
  
  /* @var $this yii\web\View */
  /* @var $model backend\models\UserLogin */
  /* @var $form yii\widgets\ActiveForm */
  ?>
<!-- <div class="user-login-form"> -->
<div class="page-header">
  <h4 class="page-title">Admin User Management</h4>
  <ol class="breadcrumb invisible">
    <li class="breadcrumb-item"><?= Html::a('Admin User Management', ['index'], ['class' => '' ]) ?></li>
    <li class="breadcrumb-item active" aria-current="page">Form #</li>
  </ol>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card  ">
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-6">
		   <div class="form-row">
            <div class="  col-md-6">
              <div>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>true]) ?>
              </div>
            </div>
            <div class="  col-md-6" id="groupDiv">
              <div>
                <?php 
                  $groups = Role::find()->where(['active_status'=>'1'])->asArray()->all();
                  $groupsAr = ArrayHelper::map($groups,'id','role_name');
                  ?>
                <?= $form->field($model, 'roleId')->dropDownList($groupsAr,['prompt'=>'Select..','class'=>'form-control','value'=>$model->roleId]);?>
              </div>
            </div>
            </div>
			 <div class="form-row">
            <div class="  col-md-6">
              <div>
                <?= $form->field($model, 'contactNumber')->textInput(['maxlength' => 10,'class'=>'form-control','onkeypress'=>'return isNumberKey(event)','placeholder'=>true]) ?>
              </div>
            </div>
            <div class="  col-md-6">
              <div>
                <?= $form->field($model, 'emailId')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>true]) ?>
              </div>
            </div>
            </div>
			 <div class="form-row">
            <div class="  col-md-6">
              <div>
                <?= $form->field($model, 'username')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>true]) ?>
              </div>
            </div>
            <div class="  col-md-6">
              <div>
                <?php
                  $model->password = "";
                  ?>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true,'class'=>'form-control','placeholder'=>true]) ?>
              </div>
            </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div  >
              <?= $form->field($model, 'address')->textarea(['rows' => 4,'class'=>'form-control h-130','placeholder'=>true]) ?>
            </div>
            <div>
              <?php
                $acSt = '1';
                if($model->is_active!=""&&$model->is_active!=NULL){
                    $acSt = $model->is_active;
                }
                ?>
              <?= $form->field($model, 'is_active')->dropDownList([ '1' => 'Active', '0' => 'InActive', ], ['value'=>$acSt]) ?>
            </div>
          </div>
          <div class="col-sm-3">
            <label>Upload Image</label>
            <input type="file" name="UserLogin[profileImage]" id="userlogin-profileimage" class="dropify" data-default-file="<?php echo Url::base()."/uploads/profileImage/user/".$model->profileImage ?>" data-height="205">
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
<script type="text/javascript">
   
  function isNumberKey(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) return false;

    return true;
  }
</script>
<!-- </div> -->