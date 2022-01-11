<?php

/* @var $this \yii\web\View */
/* @var $content string */ 
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
use backend\assets\ThemeAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\Role;
use backend\models\LeftmenuManagement;
use backend\models\IntegratedFunctionMenuMapping;
use api\modules\v1\models\MerchantMasterApi;
use api\modules\v1\models\PackageLimitationMappingApi;
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$session = Yii::$app->session;
$actual_link = explode('web/', $actual_link);
$urlKey = "";
if(!empty($actual_link)){
    if(array_key_exists('1', $actual_link)){
        if(empty($actual_link['1'])){
            $actual_link['1'] = "index";
        }
 //echo "<pre>";print_r($actual_link);die;
        if(!empty($actual_link['1'])){
            $urlKey = $actual_link['1'];
            if(strpos($urlKey, '/')){
                $new = explode('/', $urlKey);
                if(!empty($new)){
                    $urlKey = "";
                    $count = count($new);
                    for ($i=0; $i < $count; $i++) { 
                        if(!is_numeric($new[$i])){
                            if($i>0){
                                $urlKey .= '/';
                            }
                            $urlKey .= $new[$i];

                        }
                    }
                }
            }            
        }
    }else{
        echo "string";die;
    }
}

$userType = $session['user_type'];
$cntsAr = array();
if($userType=='M'){
    $btnName = "Renew";
    $merchantId = $session['merchantId'];
    $inp = array();
    $inp['apiMethod'] = "currentPackage";
    $inp['merchantId'] = $merchantId;

    $shopName = $categoryId = "";
    if($session['user_type']=="M"){
        $mercMs = MerchantMasterApi::findOne($merchantId);
        if($mercMs){
            $shopName = $mercMs->ShopName;
            $categoryId = $mercMs->shopCategoryId;
        }
    }

    $newPack = new PackageLimitationMappingApi();
    $resp = $newPack->package($inp);
    $pckTit = $msg = "";
    if(!empty($resp)){
        if($resp['status']=='error'){
            if($resp['message']=='No Package Subscription Founded'){
                $msg = $resp['message'];
            }
        }else if($resp['status']=='success'){
            if(array_key_exists('details', $resp)){
                // echo "<pre>";print_r($resp);die;
                if(!empty($resp['details'])){
                	if(array_key_exists('limitations', $resp['details'])){
                		if(!empty($resp['details']['limitations'])){
                			foreach ($resp['details']['limitations'] as $key => $oneData) {
                				# code...
                				$cntsAr[$oneData['limitationName']] = $oneData['remaining'];
                			}
                		}
                	}
                }
            }
        }
    }
    // echo "<pre>";print_r($cntsAr);die;
}




$isMenuMapped = IntegratedFunctionMenuMapping::find()->where(['LIKE','url','%'.$urlKey, false])->asArray()->one();

$activeMenuId = $activeGroupId = "";
if(!empty($isMenuMapped)){
    $activeMenuId = $isMenuMapped['menuId'];
    $activeGroupId = $isMenuMapped['groupId'];
}

$roleId = "";
if(isset($session['roleId'])){
    $roleId = $session['roleId'];
}
 


$returnContent = "";
$returnContent .= '<div class="app-sidebar__overlay" data-toggle="sidebar"></div>';
$returnContent .= '<aside class="app-sidebar doc-sidebar">';
$returnContent .= '<ul class="side-menu">';
  
    $returnContent .='<li>
                <a class="side-menu__item " href="index"><i class="side-menu__icon typcn typcn-home-outline"></i><span class="side-menu__label">Dashboard</span></a>
            </li><li class="active">
                <a class="side-menu__item  active" href="merchant-profile"><i class="side-menu__icon fa fa-user"></i><span class="side-menu__label">Merchant Profile Update</span></a>
            </li><li>';
 
if($userType=='M'){
	$returnContent .= '
	       <ul class="list-group">';
	if(!empty($cntsAr)){
		foreach ($cntsAr as $key => $value) {
			$returnContent .= '
				<li class="list-group-item justify-content-between">
					'.$key.'
					<span class="badgetext badge badge-primary badge-pill">'.$value.'</span>
				</li>';
		}
	}
	$returnContent .= '</ul>';
}
$returnContent .= '</aside>';


echo $returnContent;
?>
<?php 
    Modal::begin([
                    'header' => '<h5 id="customheader" class="modal-title"> </h5> 
					<button type="button" id="close-button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
                    'id' => 'modal', 
                    'size' => 'modal-md',
                    'closeButton' => false,
                ]);
      echo "<div id='modalContent'>
            <div id='textContent'></div>
            <div class='modal-footer'>
                <input type='hidden' class='data1'>
				<button class='btn btn-outline-primary' data-dismiss='modal' aria-hidden='true'><i class='fa fa-fw fa-ban'></i> No</button>
                ".Html::a('<i class="fa fa-fw fa-check-square-o"></i> Yes', '#', ['class' => 'btn btn-primary deletatag', 'data-method' => 'post'])."
                

            </div> 
        </div>";
    Modal::end();

?>
<!--Common Modal End -->

<!--Common Modal Starts For Custom Operation -->
<?php 
    Modal::begin([
                    'header' => '<h5 id="operationalheader"> </h5>
					<button type="button" id="close-button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
                    
                    'id' => 'operationalmodal', 
                    'size' => 'modal-md',
					'closeButton' => false,

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
                    'header' => '<h5 id="operationalheader_large"> </h5> 
					<button type="button" id="close-button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
                    
                    'id' => 'operationalmodal_large', 
                    'size' => 'modal-lg',
					'closeButton' => false,

                ]);
      echo "<div id='modalContenttwo_large'>
            <div id='customtwo_large'><input type='hidden' class='data2'></div>
        </div>";
    Modal::end();

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 
<script type="text/javascript">
	
   // location.reload();

    //Delete Modal Call
    $(document).on('click', '.modalDelete', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('<span style="color:red"> <i class="fa fa-trash"></i> Delete</span>');
            $('#textContent').html('<h4>Are you sure you want to <span style="color:red;">DELETE</span> this item ?</h4>');
            $('#modal').modal('show').find('#modalContent').load();
    });
 

    //Status Changes Model
    $(document).on('click', '.modalStatusChange', function(e){
        e.preventDefault();
         var url = $(this).val();
            $('.deletatag').attr("href", url);
            $('#customheader').html('Confirmation');
            $('#textContent').html('<h5>Are you sure you want to <span style="color:#195375;">Change the Status</span> for this item ?</h5>');
            $('#modal').modal('show').find('#modalContent').load();
    });


</script>
<style type="text/css">
	      form div.required label.control-label:after { 
  			content:" * "; 
	  		color:red; 
		}
</style>