<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\AppContentManagement;

$apName = $apShName = $apLogo = $apBgPic = $appFot = $apDesc = $apVer = $cont = $mail = $website = $devBy = "";

$appContentAll = AppContentManagement::find()->asArray()->all();
if(!empty($appContentAll)){
	$appContentAllAr = ArrayHelper::map($appContentAll,'contentKey','contentValue');
    if(!empty($appContentAllAr)){
    	if(array_key_exists('appName', $appContentAllAr)){
        	$apName = $appContentAllAr['appName'];
        }if(array_key_exists('appShortName', $appContentAllAr)){
            $apShName = $appContentAllAr['appShortName'];
        }if(array_key_exists('appLogo', $appContentAllAr)){
            $apLogo = $appContentAllAr['appLogo'];
        }if(array_key_exists('appLoginBgImg', $appContentAllAr)){
            $apBgPic = $appContentAllAr['appLoginBgImg'];
        }if(array_key_exists('appFotter', $appContentAllAr)){
            $appFot = $appContentAllAr['appFotter'];
        }if(array_key_exists('appDescription', $appContentAllAr)){
            $apDesc = $appContentAllAr['appDescription'];
        }if(array_key_exists('appVersion', $appContentAllAr)){
            $apVer = $appContentAllAr['appVersion'];
        }if(array_key_exists('contact', $appContentAllAr)){
            $cont = $appContentAllAr['contact'];
        }if(array_key_exists('email', $appContentAllAr)){
            $mail = $appContentAllAr['email'];
        }if(array_key_exists('website', $appContentAllAr)){
            $website = $appContentAllAr['website'];
        }if(array_key_exists('developedBy', $appContentAllAr)){
            $devBy = $appContentAllAr['developedBy'];
        }
    }
  }

/* @var $this yii\web\View */
/* @var $model backend\models\AppContentManagement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
	<!-- end col -->
	<div class="col-xl-12">
		<div class="card m-b-20">
			<div class="card-header">
				<h3 class="card-title">App Content management</h3>
			</div>
			<div class="card-body mb-0">
    			<?php $form = ActiveForm::begin(); ?>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="examplenameInputname2">App Name</label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="appName" id="examplenameInputname3"  placeholder="App Name" value="<?php echo $apName; ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="examplenameInputname2">App Short Name</label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="appShortName" id="examplenameInputname4"  placeholder="App Short Name" value="<?php echo $apShName; ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="examplenameInputname2">App Description</label>
							</div>
							<div class="col-md-9">
								<textarea class="content" name="appDescription"><?php echo $apDesc; ?></textarea>
							</div>
						</div>
					</div>		

					<?php 

					# Temp Stop by jana
					/*
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="exampleInputnumber6">App Logo</label>
							</div>
							<div class="col-md-9">
								<div class="col-lg-4 col-sm-12">
								<input type="file" class="dropify" data-height="180" />
							</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="exampleInputnumber6">App Login BG</label>
							</div>
							<div class="col-md-9">
								<div class="col-lg-4 col-sm-12">
								<input type="file" class="dropify" data-height="180" />
							</div>
							</div>
						</div>
					</div>
					*/
					?>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="exampleInputnumber6">App Footer</label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="appFotter" id="AppFooter1" placeholder="App Footer" value="<?php echo $appFot; ?>">
							</div>
						</div>
					</div>	
											
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="exampleInputnumber6">App Version</label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="appVersion" id="appVersion" placeholder="app Version" value="<?php echo $apVer; ?>">
							</div>
						</div>
					</div>	

					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="exampleInputnumber6">Contact Number</label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="contact" id="exampleInputnumber7" placeholder="Contact number" onkeypress= "return isNumberKey(event)" value="<?php echo $cont; ?>" maxlength="15">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="inputEmail3">Email</label>
							</div>
							<div class="col-md-9">
								<input type="email" class="form-control" name="email" id="inputEmail4" placeholder="Email"  value="<?php echo $mail; ?>">
							</div>
						</div>
					</div>									
										
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="exampleInputnumber6">Developed By</label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="developedBy" id="devBy" placeholder="Developed By" value="<?php echo $devBy; ?>">
							</div>
						</div>
					</div>					
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" id="exampleInputnumber6">Website Address</label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="website" id="websiteAddr" placeholder="Website Address" value="<?php echo $website; ?>">
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="text-right">
							<?= Html::submitButton('Save', ['class' => 'btn btn-saveNew ']) ?>
						</div>
                    </div>
				<?php ActiveForm::end(); ?>											
			</div>
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