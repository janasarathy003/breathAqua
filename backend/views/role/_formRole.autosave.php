<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AuthUserRole;
use backend\models\Role;
use yii\helpers\ArrayHelper;
use backend\models\AuthProjectModule;
use backend\models\RoleManage;
use backend\models\DesignationMaster;
use backend\models\UserLogin;
use backend\models\DropdownManagement;
/* @var $this yii\web\View */
/* @var $model backend\models\RoleManage */
/* @var $form yii\widgets\ActiveForm */
use backend\models\LeftmenuManagement;


$leftMenuData = LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['IN','menuTpe',array('group','menu')])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();

$leftMenuDataSub = LeftmenuManagement::find()->where(['activeStatus'=>'A'])->andWhere(['menuTpe'=>'submenu'])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();
$leftMenuDataSub = ArrayHelper::index($leftMenuDataSub,'menuId','groupId');
$resAr = array();
 $resAr['menu'] = "";
 $resAr['submenu'] = "";
$roleModel = Role::findOne($id);
if($roleModel){
    $resArasas = ArrayHelper::toArray(json_decode($roleModel->permissions) ) ;
    if(array_key_exists('menu', $resArasas)){
      $resAr['menu'] = $resArasas['menu'];
    }if(array_key_exists('submenu', $resArasas)){
      $resAr['submenu'] = $resArasas['submenu'];

    }
}
// echo "<pre>";print_r($resAr);die;
?>
<div class="page-header">
        <h4 class="page-title">Role Management</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><?= Html::a('Role Management', ['index'], ['class' => '' ]) ?></li>
            <li class="breadcrumb-item active" aria-current="page">Roles Permission</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card  ">
                <?php $form = ActiveForm::begin(); ?>
                <div class="card-body">
                  
                    <div class="form-row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
                                  <h3> Only Selected Functionalities are Allowd to that Role based Users </h3>
                            <?php 
                        
                                 
                                $content = "";
                                if(!empty($leftMenuData)){
                                    $content .= '<ul >';
                                    foreach ($leftMenuData as $catId => $oneMenu) {
                                        $isMenuChecked = $isSubMenuChecked = "";
                                        if(!empty($resAr)){
                                          if(array_key_exists('menu', $resAr)){
                                            
                                            if(in_array($oneMenu['menuId'], $resAr['menu'])){
                                              $isMenuChecked = "checked";
                                            }
                                          }
                                        }
                                        $content .= '<li>';
                                        $content .= '<input name="cateIds[]" value="'.$oneMenu['menuId'].'"  type="checkbox" '.$isMenuChecked.' />'.$oneMenu['Name'].' ';
                                        // array_key_exists(key, array)
                                        if(array_key_exists( $oneMenu['groupId'],$leftMenuDataSub) && !empty($leftMenuDataSub[$oneMenu['groupId']])){
                                                $content .= '<ul>';
                                            foreach ($leftMenuDataSub[$oneMenu['groupId']] as $key => $oneSubMenu) {
                                                $isSubMenuChecked = "";

                                                if(!empty($resAr)){
                                                if(in_array($oneSubMenu['menuId'], $resAr['submenu'])){
                                                  
                                                    $isSubMenuChecked = "checked";
                                                }
                                              }

                                                $content .= '<li><input name="subcateIds[]" value="'.$oneSubMenu["menuId"].'" type="checkbox" '.$isSubMenuChecked.' />'.$oneSubMenu['Name'].'</li>'; 
                                            }
                                            $content .= '</ul>';
                                        }                                    
                                        $content .= '</li>';
                                    }
                                    $content .= '</ul>';
                                }
                                echo $content;
                              ?>
                          </div>
                      </div>
                  </div>
                  <div class="card-footer">
                      <div class="text-right">
                          <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-square']) ?>
                      </div>
                    
                  </div>
                  <?php ActiveForm::end(); ?>
              </div>
        </div>
    </div>