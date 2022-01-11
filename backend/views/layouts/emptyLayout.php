<?php 
use backend\assets\AppAsset;
use backend\assets\ThemeAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Modal;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

ThemeAsset::register($this);
$profileImg = Url::base().'/images/user1.png';
$url = Yii::$app->controller->action->id;
/*echo $url; die;*/

$session = Yii::$app->session; // echo "<pre>"; print_r($_SESSION); die;
if(array_key_exists('userProfile', $session) || isset($session['userProfile'])){
    if($session['userProfile']!=""){
        $profileImg = $session['userProfile'];
    }
} 
$base = Url::base(true);

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
                           <!--  <img src="#" class="header-brand-img desktop-logo" alt="logo"> 
                            <img src="#" class="header-brand-img mobile-logo" alt="logo"> -->
    						<span class="text-white desktop-logo" style="position: relative;top: 16px;">aFynder</span>
    						<span class="text-white header-brand-img mobile-logo" style="position: relative;top: 5px;">aF</span>
                        </a><!-- LOGO -->
                    </div>
                    <div class="d-flex ml-auto header-right-icons">                   
                        <div class="dropdown d-none d-md-flex" >
                            <a class="nav-link icon full-screen-link">
                                <i class="fe fe-maximize-2"  id="fullscreen-button"></i>
                            </a>
                        </div>                   
                        <div class="dropdown "> 
                            <a href="#" class="nav-link pr-0 leading-none user-img" data-toggle="dropdown">
                                <img src="<?php echo $profileImg; ?>" class="avatar avatar-md brround">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                                <!-- <a class="dropdown-item" href="profile.html">
                                    <i class="dropdown-icon icon icon-user"></i> My Profile
                                </a> -->
                                
                                <?php  echo Html::a('<i class="dropdown-icon icon icon-power"></i>Logout', Url::base().'/index.php?r=site/logout', ['class'=>'dropdown-item']); ?>
                                
                            </div>
                        </div><!-- SIDE-MENU -->
                    </div>
                </div>
                <div class="app-content" style="margin-left: 0px;">
                    <div class="side-app">
                        <?= Alert::widget() ?>     
                        <?php  
                             echo $content;
                        ?>
                    </div>
                </div>
            </div>

            <!--footer-->
            <footer class="footer">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
                            Copyright © 2020 <a href="#">aFynder</a>. Designed by <a href="https://www.istrides.in" target="_blank">IStrides Technologies</a> All rights reserved.
                        </div>
                    </div>
                </div>
            </footer>
            <!-- End Footer-->
        </div>

        <!-- Back to top -->
        <a href="#top" id="back-to-top" ><i class="fa fa-rocket"></i></a>

        <?php 
            Modal::begin([
                'header' => '<h3 id="customheader"> </h3>',
                'id' => 'modal', 
                'size' => 'modal-md',
            ]);
            echo "<div id='modalContent'>
                <div id='textContent'></div>
                <div class='modal-footer'>
                    <input type='hidden' class='data1'>
                    ".Html::a('<i class="fa fa-fw fa-check-square-o"></i> Yes', '#', ['class' => 'btn btn-primary deletatag', 'data-method' => 'post'])."
                    <button class='btn' data-dismiss='modal' aria-hidden='true'><i class='fa fa-fw fa-ban'></i> No</button>
                </div> 
            </div>";
            Modal::end();
        ?>
        <!--Common Modal End -->

        <!--Common Modal Starts For Custom Operation -->
        <?php 
            Modal::begin([
                'header' => '<h3 id="operationalheader"> </h3>',
                'id' => 'operationalmodal', 
                'size' => 'modal-md',
            ]);
            echo "<div id='modalContenttwo'>
                <div id='customtwo'><input type='hidden' class='data2'></div>
            </div>";
            Modal::end();
        ?>
        <!--Common Modal End -->

        <!--Common Modal Starts For Custom Operation -->
        <?php 
            Modal::begin([
                'header' => '<h3 id="operationalheader_large"> </h3>',
                'id' => 'operationalmodal_large', 
                'size' => 'modal-lg',
            ]);
            echo "<div id='modalContenttwo_large'>
                <div id='customtwo_large'><input type='hidden' class='data2'></div>
            </div>";
            Modal::end();
        ?>
        <?php $this->endBody() ?>

        <script type="text/javascript" src="/afynder/backend/web/plugins/js/jquery.backstretch.js"></script>
        <script>		  
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
                $('.f1 .btn-next').on('click', function() {
                	var parent_fieldset = $(this).parents('fieldset');
                	var next_step = true;
                	// navigation steps / progress steps
                	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
                	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
                	
                	// fields validation
                	parent_fieldset.find('input[type="text"], select, input[type="password"], textarea').each(function() {
                		var attr = $(this).attr('aria-required'); 
             
                if (typeof attr !== typeof undefined && attr !== false) {
                        if($(this).val() == "") {
                           // e.preventDefault();
                            $(this).addClass('input-error');
                            next_step = false; //return false;
                        }
                        else{
                          //  $(this).removeClass('input-error');
                           // next_step = true;
                        }
                         }/*else{   
                            $(this).removeClass('input-error');  
                            next_step = true;
                         }*/
                	});
                	// fields validation
                	
                	if( next_step ) {
                		parent_fieldset.fadeOut(400, function() {
                			// change icons
                			current_active_step.removeClass('active').addClass('activated').next().addClass('active');
                			// progress bar
                			bar_progress(progress_line, 'right');
                			// show next step
            	    		$(this).next().fadeIn();
            	    		// scroll window to beginning of the form
                			scroll_to_class( $('.f1'), 20 );
            	    	});
                	}
                	
                });
                
                // previous step
                $('.f1 .btn-previous').on('click', function() {
                	// navigation steps / progress steps
                	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
                	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
                	
                	$(this).parents('fieldset').fadeOut(400, function() {
                		// change icons
                		current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
                		// progress bar
                		bar_progress(progress_line, 'left');
                		// show previous step
                		$(this).prev().fadeIn();
                		// scroll window to beginning of the form
            			scroll_to_class( $('.f1'), 20 );
                	});
                });
                
                // submit
                $('.f1').on('submit', function(e) {
                	
                	// fields validation
                	$(this).find('input[type="text"], input[type="password"], textarea').each(function() {
                		  var attr = $(this).attr('aria-required'); 
             
                     if (typeof attr !== typeof undefined && attr !== false) {
                        if($(this).val() == "") {
                           // e.preventDefault();
                            $(this).addClass('input-error');
                            next_step = false;  
                        }
                        else{
                          //  $(this).removeClass('input-error');
                                      
                         }
                        } 
                	});
                	// fields validation
                });   
            });
		
            $("input").keypress(function(event) {
                if (event.which == 13) { return false;
                }   
            });
            $(window).load(function() { 
                //$("#global-loader").show(); 
            });
		</script>
    </body>
	
</html>
<?php $this->endPage() ?>
