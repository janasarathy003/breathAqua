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

    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $session = Yii::$app->session;
    $actual_link = explode('admin/', $actual_link);
    $urlKey = "";
    if(!empty($actual_link)){
        if(array_key_exists('1', $actual_link)){
            if(empty($actual_link['1'])){
                $actual_link['1'] = "index";
            }
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
        }
    }

    $cntsAr = array();
    $isMenuMapped = IntegratedFunctionMenuMapping::find()->where(['LIKE','url','%'.$urlKey, false])->asArray()->one();
    $roleId = $activeMenuId = $activeGroupId = "";
    if(!empty($isMenuMapped)){
        $activeMenuId = $isMenuMapped['menuId'];
        $activeGroupId = $isMenuMapped['groupId'];
    }
    if(isset($session['roleId'])){
        $roleId = $session['roleId'];
    }

    $permission = array();
    $roldMs = Role::find()->where(['id'=>$roleId])->andWhere(['active_status'=>'1'])->asArray()->one();
    if(!empty($roldMs)){
        $permissionAll = ArrayHelper::toArray(json_decode($roldMs['permissions']));
        if(!empty($permissionAll)){
            if(array_key_exists('menu', $permissionAll)){
                $permission = array_merge($permission,$permissionAll['menu']);
            }if(array_key_exists('submenu', $permissionAll)){
                $permission = array_merge($permission,$permissionAll['submenu']);
            }
        }
    }

    $menuFor = 'admin';

    $leftMenuData = LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['menuFor'=>$menuFor])->andWhere(['IN','menuTpe',array('group','menu')])->andWhere(['IN','menuId',$permission])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();

    $leftMenuDataSub = LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['menuFor'=>$menuFor])->andWhere(['menuTpe'=>'submenu'])->andWhere(['IN','menuId',$permission])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();
    $leftMenuDataSub = ArrayHelper::index($leftMenuDataSub,'menuId','groupId');

    $returnContent = "";
    $returnContent .= '<div class="app-sidebar__overlay" data-toggle="sidebar"></div>';
    $returnContent .= '<aside class="app-sidebar doc-sidebar">';
    $returnContent .= '<ul class="side-menu">';
    if(!empty($leftMenuData)){
        foreach ($leftMenuData as $key => $oneData) {
            if($oneData['menuTpe']=='group'){
                $expend = "";
                if($activeGroupId==$oneData['menuId']){
                    $expend = "is-expanded";
                } 
                $returnContent .= '
                    <li class="slide '.$expend.'">
                        <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon '.$oneData['faIcon'].'"></i><span class="side-menu__label">'.$oneData['Name'].'</span><i class="angle fa fa-angle-right"></i></a>';
                        if(array_key_exists($oneData['menuId'], $leftMenuDataSub)){ 
                            if(!empty($leftMenuDataSub[$oneData['menuId']])){
                                $returnContent .= '<ul class="slide-menu">';
                                foreach ($leftMenuDataSub[$oneData['menuId']] as $key => $oneSubMenu) {
                                    $isActive = "";
                                    if($activeMenuId==$oneSubMenu['menuId']){
                                        $isActive = "active";
                                    }
                                    $returnContent .= '<li><a class="slide-item '.$isActive.'" href="'.Url::base(true).'/'.$oneSubMenu['userUrl'].'"><i class="fa fa-angle-right mr-1"></i>'.$oneSubMenu['Name'].'</a></li>';
                                }
                                $returnContent .= '</ul>';
                            }
                        }
                    $returnContent .= '</li>
                ';
            }else if($oneData['menuTpe']=='menu'){  
                $isActive = "";
                if($activeMenuId==$oneData['menuId']){
                    $isActive = "active";
                }
                $returnContent .= '<li>
                    <a class="side-menu__item '.$isActive.'" href="'.Url::base(true).'/'.$oneData['userUrl'].'"><i class="side-menu__icon '.$oneData['faIcon'].'"></i><span class="side-menu__label">'.$oneData['Name'].'</span></a>
                </li>';
            }
        }    
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
 
<script type="text/javascript">
    //Delete Modal Call
    $(document).on('click', '.modalDelete', function(e){
        e.preventDefault();
        var url = $(this).val();
        $('.deletatag').attr("href", url);
        $('#customheader').html('<span style="color:red"> <i class="fa fa-trash"></i> Delete</span>');
        $('#textContent').html('<h4>Are you sure you want to <span style="color:red;">DELETE</span> this record ?</h4>');
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