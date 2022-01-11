<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = "Register";
//echo "<pre>"; print_r($register); die; 
?>
<style>
  .horizontal-main {
    background-color: #2a359c!important;
}

.sticky-wrapper.is-sticky .horizontalMenu>.horizontalMenu-list>li>a{color:#fff;} 
</style>
<div class="sptb card p-10">
<div class="page-content z-index-10"> 
<div class="container text-center"> 
<!-- <div class="display-1   mb-5">Success</div> 
 --> 
 <div class="row justify-content-md-center">
<div class="col-sm-8 message-block">
 <?php   
 $register = "merchant"; //echo $register; die;
 if ($register=="merchant") { # merchant register<p class="text-center h4 mt-5">You will be automatically redirecting to Login in  <span id="seconds-merchant">10</span>  seconds!!!</p> ?>  
    <i class="fa fa-thumbs-o-up fa-5x text-success"></i>
	 <h1 class="mb-3 text-success">Registration Success!</h1>
	 <p class="h2 font-weight-normal mt-5">Thanks for your registration</p> 
	 <p class="h3 font-weight-normal mt-5 leading-normal">Your Registration as Merchant is Completed Successfully</p> 
	 
	 <a class="btn btn-primary mt-5" href="home"> Go to Login </a>
	 
       <?php }  ?>
 
 <!-- <a class="btn btn-primary" href="backend/web"> Click To Login </a>  -->
 </div> 
 </div> 
 </div> 
 </div>
 </div>
 
 
   
   
	  
	  
	  
