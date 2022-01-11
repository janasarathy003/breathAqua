<?php 
use backend\assets\AppAsset;
use backend\assets\ThemeAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url; 
use yii\widgets\ActiveForm;
use backend\models\AppContentManagement;
ThemeAsset::register($this);

$base = Url::base(true);

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
        }
    }
}
?>
 
<?php $this->beginPage() ?>
<!doctype html>
 
<html lang="en" dir="ltr">
    <head>
        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Afynder">
        <meta name="author" content=" ">
        <meta name="keywords" content="">      <link rel="icon" href=" " type="image/x-icon"/>
        <link rel="shortcut icon" type="image/x-icon" href=" " />
        <!-- Title -->
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style type="text/css">
            .table th, .text-wrap table th {
                color: #3f3e50;
                text-transform: capitalize !important;
                font-size: .875rem;
                font-weight: 400;
            }
            .mail input{color:#000;}
        </style>
        
        <script src="<?php echo Url::base().'/'?>js/jquery-3.2.1.min.js"></script>
    </head>
    <div id="global-loader">
        <img src="<?php echo Url::base().'/'?>images/loader.png" class="loader-img floating" alt="">
    </div>
    <body class="app sidebar-mini">
    <?php $this->beginBody() ?>
        <div class="page">
            <div class="page-main">
        
            <div class="app-header1 header-search-icon">
                <div class="header-style1">
                        <a class="header-brand" href="<?php echo $base.'/';?>index">
                            <span class="text-white desktop-logo" style="position: relative;top: 16px;"><?php echo $appName; ?></span>
                            <span class="text-white header-brand-img mobile-logo" style="position: relative;top: 5px;"><?php echo $appShortName; ?></span>
                        </a><!-- LOGO -->
                    </div>
                
                
                <div class="app-sidebar__toggle" data-toggle="sidebar">
                    <a class="open-toggle" href="#"><i class="fe fe-align-left"></i></a>
                    <a class="close-toggle" href="#"><i class="fe fe-x"></i></a>
                </div> 
             
                 
                  
                  
                <div class="d-flex ml-auto header-right-icons">
                   
                    <div class="dropdown d-none d-md-flex" >
                        <a class="nav-link icon full-screen-link">
                            <i class="fe fe-maximize-2"  id="fullscreen-button"></i>
                        </a>
                    </div>
                   
                    <div class="dropdown "> 
                       
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                          
                            
                        </div>
                    </div><!-- SIDE-MENU -->
                </div>
            </div>

        <?php
         
             echo $this->render('user_menu.php',['id'=>'userchange']);
         
          ?>
       
          <div class="app-content">
        <div class="side-app">
         
        <?= Alert::widget() ?>    
        <?php echo $content;  ?>  
         </div>
    </div>
            </div>

            
            <!--footer-->
            <footer class="footer">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
                            Copyright © <?php echo date('Y'); ?> <a href="#"><?php echo $appName; ?></a>. Designed by <a href="https://www.istrides.in" target="_blank"><?php echo $appDevBy; ?></a> <?php echo $appFooter; ?>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Footer-->
        </div>
 
 
 
        <!-- Back to top -->
        <a href="#top" id="back-to-top" ><i class="fa fa-rocket"></i></a>


 
     

<?php $this->endBody() ?>
  
          <script type="text/javascript" src="/afynder/backend/web/plugins/js/jquery.backstretch.js"></script>
  
          
            <?php $baseUrl = Url::base(true);
        $files=$baseUrl.'/images/Logo.png'; ?> 
       <script type="text/javascript">
     
  
      $lock_ajax=true;
     
function scroll_to_class(element_class, removed_height) {
    var scroll_to = $(element_class).offset().top - removed_height;
    if($(window).scrollTop() != scroll_to) {
        $('html, body').stop().animate({scrollTop: scroll_to}, 0);
    }
}

function bar_progress(progress_line_object, direction) {
    var number_of_steps = progress_line_object.data('number-of-steps');
    var now_value = progress_line_object.data('now-value');
    var new_value = 0;
    if(direction == 'right') {
        new_value = now_value + ( 100 / number_of_steps );
    }
    else if(direction == 'left') {
        new_value = now_value - ( 100 / number_of_steps );
    }
    progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
}

jQuery(document).ready(function() {
    
    /*
        Fullscreen background
    */
   // $.backstretch("assets/img/backgrounds/1.jpg");
    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
        $.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
        $.backstretch("resize");
    });
    
    /*
        Form
    */
    $('.f1 fieldset:first').fadeIn('slow');
    
    $('.f1 input[type="text"], .f1 input[type="password"], .f1 textarea').on('focus', function() {
        $(this).removeClass('input-error');
    });
    
    // next step
 
    
 
    
    
});
        
$("input").keypress(function(event) {
if (event.which == 13) { return false;
}
});
 
        </script>
		<script>
   $(document).ready(function(){
	  $('body') .addClass('sidenav-toggled');
	   
	  //$("input").attr("name", "email").focus();
   });
 
 </script>
    </body>
    
</html>
<?php $this->endPage() ?>
