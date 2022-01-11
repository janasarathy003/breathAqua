<?php 
  use yii\helpers\Url; 
  use yii\helpers\ArrayHelper; 
  use api\modules\v1\models\MerchantCategoryMasterApi;
  use api\modules\v1\models\ProductMasterApi;
  
    $requestInput = array();
    $requestInput['apiMethod'] = 'CategoryList';
    $requestInput['callFrom'] = 'siteHome';
  
    $newMs = new MerchantCategoryMasterApi();
    $categoryResponse  = $newMs->CategoryList($requestInput);
  $this->title = "Change Password - aFynder";
  $autoid="";
  if (array_key_exists("data", $_GET)) {
    $autoid=base64_decode($_GET['data']);
  }  

  // echo "string";die;
  ?>
 
<!--Sliders Section-->
<section>
  <div class="banne rimg cover-i mage bg-b ackground3 mt-6" data-image-src=" ">
    <div class="header-text mb-0">
      <div class="container">
        <div class="text-center tex t-white">
          <h1 class="">Reset Password!</h1>
          <!-- <ol class="breadcrumb text-center">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Login</li>
            </ol> -->
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Sliders Section-->
<!--Login-Section-->

<!--Forgot password-->
        <section class="sptb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-xl-4 col-md-6 d-block mx-auto">
                        <div class="single-page w-100 p-0" >
                            <div class="wrapper wrapper2" style="color: #000;">
                                <form id="forgotpsd" method="post" class="card-body" autocomplete="off">
                                  <input type="hidden"  name="emailid"  value="<?php echo $mailid; ?>" >
                                      <input type="hidden" id="autoid" name="autoid"  value="<?php echo $autoid; ?>" >
                                    <h3 class="pb-2"><?php echo $mailid; ?></h3>
                                    <div class="mail"> 
                                        <input type="password" id="password"  name="" required>
                                        <label>New Password</label>
                                    </div>
                                    <div class="mail">
                                        <input type="password" name="" id="confirmpassword" required>
                                        <label>Confirm Password</label>
                                    </div>
                                    <?php if (isset($message) && $message!="") { ?>
                                        <span class="text-center text- dark mb-0" style="color: red;">
                                        <?php echo $message; ?>
                                    </span>
                                    <?php } ?>
                                    <div class="registrationFormAlert" style="color:green;" id="CheckPasswordMatch"></div>
                                    <div class="submit"> 
                                        <button type="button" class="btn btn-secondary save btn-block">Update</button>
                                    </div>
                                    <div class="text-center text-dark mb-0">
                                      I Remember it, <a href="/merchant/home" style="text-decoration: underline;">send me back</a> to the sign in.
                   
                                    </div>
                             
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/Forgot password-->
<script>
    $(".save").click(function(){
        var password = $("#password").val();
        var confirmPassword = $("#confirmpassword").val();

        if (password=="" || confirmPassword==""){
            $("#CheckPasswordMatch").css("color",'red');
            $("#CheckPasswordMatch").html("Fields Cannot be Blank"); return false;
        }

        if (password != confirmPassword){
            $("#CheckPasswordMatch").css("color",'red');
            $("#CheckPasswordMatch").html("Passwords does not match!");
            $("#confirmpassword").val(""); return false;
        }
        else{
            $("#CheckPasswordMatch").css("color",'green');
            $("#CheckPasswordMatch").html("Passwords match."); 
                $("#forgotpsd").submit();
            
        }
    });
   /* $(document).ready(function () {
       $("#confirmpassword").keyup(checkPasswordMatch);
       $("#password").keyup(checkPasswordMatch);
    }); */ 
    </script>

<a href="#top" id="back-to-top"><i class="fa fa-rocket"></i></a>
 