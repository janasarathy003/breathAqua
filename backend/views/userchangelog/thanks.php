<?php 
use yii\helpers\Url; 
use yii\helpers\ArrayHelper;
  
  $this->title = "Change Password";
  $base = Url::base(true); 
  ?>
 
<!--Sliders Section-->
    <div class="header-text mb-0">
      <div class="container">
        <div>
          <h1 class="">Your Password has been reset!</h1>
        </div>
        <div class="text-center text-dark mb-0">
         <a href="<?php echo $base.'/';?>index" style="text-decoration: underline;">Click here</a> to the login page.
        </div>
      </div>
    </div>
  <div>