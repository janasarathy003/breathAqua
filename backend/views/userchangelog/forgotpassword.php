<?php 
  use yii\helpers\Url; 
  use yii\helpers\ArrayHelper; 


  $this->title = "Forgot Password - aFynder";
  $usertype="";
  if (array_key_exists("id", $_GET)) {
    $usertype=base64_decode($_GET['id']);
  } //echo $merchant; die;
  
    $base = Url::base(true); 
  ?>
 
<!--Sliders Section-->
<section>
  <div class="banner img co ver-image b g-background3 mt-6" data-image-src=" ">
    <div class="header-text mb-0">
      <div class="container">
        <div class="text-center te xt-white">
          <h1 class="">Forgot Password!</h1>
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
                            <div class="wrapper wrapper2">
                                <form id="forgotpsd" method="post" class="card-body">
                                    <h3 class="pb-2" style="font-size: 17px;">To reset password, type your registered Mobile No. or Email ID below,</h3>
                                    <div class="mail">
                                        <input type="text" name="email" required > 
                                        <label>Email ID or Mobile Number</label>
                                    </div>
                                    <?php if (isset($message) && $message!="") { ?>
                                        <span class="text-center text- dark mb-0" style="color: red;">
                                        <?php echo $message; ?>
                                    </span>
                                    <?php } ?>
                                    <div class="submit"> 
                                        <button type="submit" class="btn btn-secondary btn-block">Send</button>
                                    </div>
                                    <div class="text-center text-dark mb-0"> 
                                        I Remember it, <a href="<?php echo $base.'/';?>index" style="text-decoration: underline;">send me back</a> to the sign in.
                                  
                                    </div>
                             
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/Forgot password-->


<a href="#top" id="back-to-top"><i class="fa fa-rocket"></i></a>
 