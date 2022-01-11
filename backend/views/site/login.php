<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\AppContentManagement;
  
 // $bgImg = $appLogo = $appName = $appDevBy = "";
  $baseUrl = Url::base();
  // echo $baseUrl;die;
  $baseUrl = str_replace('/admin', '/backend/web', $baseUrl);

  $appFooter = $appShortName = $bgImg = $appLogo = $appName = $appDevBy = "";

  $appContentAll = AppContentManagement::find()->asArray()->all();
  if(!empty($appContentAll)){
      $appContentAllAr = ArrayHelper::map($appContentAll,'contentKey','contentValue');
      if(!empty($appContentAllAr)){
          if(array_key_exists('appName', $appContentAllAr)){
            $appName = $appContentAllAr['appName'];
          }if(array_key_exists('appShortName', $appContentAllAr)){
                $appShortName = $appContentAllAr['appShortName'];
          }if(array_key_exists('appLogo', $appContentAllAr)){
            $appLogo = $appContentAllAr['appLogo'];
          }if(array_key_exists('appFotter', $appContentAllAr)){
                $appFooter = $appContentAllAr['appFotter'];
          }if(array_key_exists('developedBy', $appContentAllAr)){
                $appDevBy = $appContentAllAr['developedBy'];
          }if(array_key_exists('appLoginBgImg', $appContentAllAr)){
            $bgImg = $appContentAllAr['appLoginBgImg'];
          }
      }
  }

$this->title = $appName.' - Login'; $this->params['breadcrumbs'][] = $this->title; 
?>
<script src="<?php echo Url::base().'/'?>js/jquery-3.2.1.min.js"></script>
<style type="text/css">
  .login100-more::before {
    background: none !important;
  }
  .single-page .wrapper input {
    margin-top: 0px !important; 
  }
  #w0-error-0 {
    font-size: 15px;
  }
  sup.er{color:red;font-size: 10px;}
  .req{border: solid 1px #dd4b39;}
  .table {
    display: table;
    width: 100%;
    height: 100%;
  }
  .table-cell {
    display: table-cell;
    vertical-align: middle;
    -moz-transition: all 0.5s;
    -o-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
  }
 
  .facebook .btn .btn-primary{
    display: none!important;
  }
  .google .btn .btn-info{
    display: none!important;
  }
  .rules{
        position:relative;
    bottom:3px;
  }
  .rules a{font-size:13px;}
  .homreg_box{
      width: 5% !important;
      height: 15px !important;
      float: left !important; 
  }  
  a.facebook.highlight-button{
  margin-left: 15px;
  }
 .remember-me{
      margin-left: 5px;
      margin-top: 5px;
      font-size: 13px;
}
  #w0-error-0{
  display: none;
 }

</style>
<!--Page-->
<div class="pa ge h-100">
  <div class="pa ge-content z-index-10">
    
  
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
          <?php $form = ActiveForm::begin(['id' =>
              'login-form','options' => [ 'class' => 'login100-form validate-form' ]]); ?>
          
          <span class="login100-form-title p-b-34">
            USER ACCOUNT
            <!-- <img src="../web/images/Logo.png"  > -->
          </span>
          <?php session_start(); if (array_key_exists('error', $_SESSION) &&  $_SESSION['error']=="yes") {  ?>
          <div class="alert alert-danger  alert-dismissible" role="alert" style="float: right;font-size: 13px; width: 100%;padding-bottom: 0px; padding-top: 20px;"> Incorrect Username or Password<button type="button" style="top: -7px; color: #131212 !important;" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          </div>
          <?php } ?>
          <div class="wrap-input100 rs1-wrap-input100 validate-input " data-validate="Type user name">
             
             <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => '  form-control'])->label('Email ID / Phone No'); ?>
             
          </div>
          <div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20 " data-validate="Type password">
            <?= $form->field($model, 'password')->passwordInput(['class' => '  form-control'])->label('Password'); ?>
             
          </div>
           <div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" style="text-align: right;">
          <a href="<?php echo "//$_SERVER[HTTP_HOST]/2021/istBase/admin/forgotpassword?id=bWVyY2hhbnQ="; ?>" >Forgot Password?</a>
          </div>
          <div class="container-login100-form-btn">
             
            <?= Html::submitButton('Login', ['class' =>
                'btn btn-primary btn-block', 'name' => 'login-button']) ?>
          </div>
     
           
        <?php ActiveForm::end(); ?>
 
   <div class="login100-more" style="background-image: url('<?php echo $bgImg; ?>');">
          
        </div>
        
      </div> 
    </div> 
  </div>
    </div>
</div>
<small style="position:fixed;bottom:0;left:0; color:#c0c0c0;" class="ml-4 ml-sm-5   ">Copyright © <?php echo date('Y'); ?> <a href="#" class="c-1"><?php echo $appName; ?></a>. Designed by <a href="https://www.istrides.in/" target="_blank" class="c-1"><?php echo $appDevBy; ?></a> <?php echo $appFooter; ?></small>
   
  
  
  
  
  
      
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

    