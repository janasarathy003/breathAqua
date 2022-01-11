<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = "Password!";
 ?>
<style>
  .horizontal-main {
    background-color: #2a359c!important;
}

.sticky-wrapper.is-sticky .horizontalMenu>.horizontalMenu-list>li>a{color:#fff;} 
</style>
<div class="sptb p-5 card">
<div class="page-content z-index-10"> 
<div class="container text-center"> 
<!-- <div class="display-1   mb-5">Success</div> 
 --> 
 <div class="row justify-content-md-center">
<div class="col-sm-12 message-block">
 <?php  //echo $_SERVER['HTTP_HOST']; die;
 //$register = "merchant";
 if (array_key_exists('register', $_GET)) {
   $register = $_GET['register'];
 }
 if ($register=="merchant") { # merchant register<p class="text-center h4 mt-5">You will be automatically redirecting to Login in  <span id="seconds-merchant">10</span>  seconds!!!</p>  
     echo '<i class="fa fa-thumbs-o-up fa-5x text-success"></i>
   <h1 class="mb-3 text-success">Registration Success!</h1>
   <p class="h2 font-weight-normal mt-5">Thanks for your registration</p> 
   <p class="h3 font-weight-normal mt-5 leading-normal">Your Registration as Merchant is Completed Successfully</p> 
   
   <a class="btn btn-primary mt-5" href="backend/web/home"> Go to Login </a>
   ';
        }else if($register=="shopee-register"){ # shopee register
          echo ' <i class="fa fa-thumbs-o-up fa-5x text-success"></i>
      <h1 class="mb-3 text-success mt-5">Registration Success!</h1> 
       <p class="h2 font-weight-normal mt-5">Thanks for your registration</p> 
      <p class="h3 font-weight-normal mt-5 leading-normal  ">Your Registration as Shopee is Completed Successfully</p>
       <p class="text-center h4 mt-5">You will be automatically redirecting to Listings in  <span id="seconds">10</span>  seconds!!!</p>
  
      <a class="btn btn-primary mt-5" href="home"> Go to Home </a>
   <a class="btn btn-pink mt-5" href="listings"> Go to Listings </a>
   <a class="btn btn-purple mt-5" href="categories"> Go to Categories </a>';

        }else if($register=="Forget"){  # Forget Password mail sent
          echo '<h1 class="">Forgot Password!</h1> <p class="h3 font-weight-normal mt-3 leading-normal" style="font-size: 1.3rem;"> We have sent you an email with password reset instruction. Please check your registered email id and follow the instruction given!</p>';
        }else if($register=="merchant-password-update"){   # merchant Forget Password Success
          echo '<i class="fa fa-thumbs-o-up fa-5x text-success"></i>
   <h1 class="mt-3 text-success"> Success!</h1> <p class="h3 font-weight-normal mt-3 leading-normal" style="font-size: 1.3rem;">Your password has been reset successfully. Proceed to login to your account with the new password!</p>
   <a class="btn btn-primary mt-3" href="/merchant/home"> Click to Login</a>';
        }else if($register=="shopee-password-update"){  # shopee Forget Password Success
          echo '<i class="fa fa-thumbs-o-up fa-5x text-success"></i>
   <h1 class="mt-3 text-success"> Success!</h1> <p class="h3 font-weight-normal mt-3 leading-normal" style="font-size: 1.3rem;">Your password has been reset successfully. Proceed to login to your account with the new password!</p>
   <a class="btn btn-primary mt-3" href="login"> Click to Login</a> ';
        }
        else if($register=="password-error"){  # Forget Password mail sent
          echo '<h1 class="mt-3">Password Change</h1> <p class="h3 font-weight-normal mt-3 leading-normal">Password Not Matched Please Try Again</p>
      <a class="btn btn-primary mt-3" href="forgotpassword"> Try Again</a> ';
        }else if($register=="link-error"){  # Forget Password mail sent

          echo '<i class="fa fa-exclamation-triangle fa-5x text-danger"></i><h1 class="mt-3">Invalid Link!</h1> <p class="h3 font-weight-normal mt-3 leading-normal">This link is expired or already used to reset password!</p>
      <a class="btn btn-primary mt-3" href="forgotpassword"> Try Again</a> ';
        }
        else if ($register=="failure") { # shpee and merchant register failure
        echo '<i class="fa fa-thumbs-o-down fa-5x text-danger"></i>
      <h1 class="mb-3 text-danger mt-5">Registration Failed..</h1> 
      <p class="h2 font-weight-normal mt-5 leading-normal">Register Not Completed Please Try Again</p>
      <a class="btn btn-primary mt-5" href="login"> Click to Register</a> ';
        }
        else if ($register=="login-failure") { # shpee and merchant Login failure
        echo '<i class="fa fa-thumbs-o-down fa-5x text-danger"></i><h1 class="mt-3 text-danger">Login Failed..</h1> 
      <p class="h3 font-weight-normal mt-3 leading-normal  ">Registration Not Completed Please Try Again</p> 
      <a class="btn btn-primary mt-3" href="login"> Click to Register</a> ';
        }
         ?>
 
 <!-- <a class="btn btn-primary" href="backend/web"> Click To Login </a>  -->
 </div> 
 </div> 
 </div> 
 </div>
 </div>
 
 
   
    <script>
        setInterval(function() {
            var div = document.querySelector("#seconds-merchant");
            var count = div.textContent * 1 - 1;
            div.textContent = count;
            if (count <= 0) {
                window.location.replace("backend/web/home");
            }
        }, 1000);
    
    
     setInterval(function() {
            var div1 = document.querySelector("#seconds");
            var count1 = div1.textContent * 1 - 1;
            div1.textContent = count1;
            if (count1 <= 0) {
                window.location.replace("listings");
            }
        }, 1000);
    </script>
   
   
   
   <script>
        /* var seconds = 30;  
         var foo;  
         function redirect() {
            document.location.href = 'listings';
         }

         function updateSecs() {
            document.getElementById("seconds").innerHTML = seconds;
            seconds--;
            if (seconds == -1) {
              clearInterval(foo);
              redirect();
            }
        }

        function countdownTimer() {
            foo = setInterval(function () {
              updateSecs()
            }, 1000);
        }

         countdownTimer();   */ 
      </script>
    
    
    
    
    
     <script>
       /*  var seconds1 = 30;  
         var inter;  
         function redirect() {
            document.location.href = 'backend/web/home';
         }

         function updateSecsmer() {
            document.getElementById("seconds-merchant").innerHTML = seconds1;
            seconds1--;
            if (seconds1 == -1) {
              clearInterval(inter);
              redirect();
            }
        }

        function countdownTimermer() {
            inter = setInterval(function () {
              updateSecsmer()
            }, 1000);
        }

         countdownTimermer();   */
      </script>
    
    
    
    
