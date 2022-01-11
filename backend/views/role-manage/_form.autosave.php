<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AuthUserRole;
use yii\helpers\ArrayHelper;
use backend\models\AuthProjectModule;
use backend\models\RoleManage;
use backend\models\DesignationMaster;
use backend\models\UserLogin;
use backend\models\DropdownManagement;
/* @var $this yii\web\View */
/* @var $model backend\models\RoleManage */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;

?>
<div class="page-header">
        <h4 class="page-title">Role Management</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><?= Html::a('Role Management', ['index'], ['class' => '' ]) ?></li>
            <li class="breadcrumb-item active" aria-current="page">Role Management Form</li>
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


<h5> Only Selected Categories will be Availabe for this Client </h5>
                    <?php 
                        $cat = CategoryMaster::find()->where(['activeStatus'=>'A'])->asArray()->all();
                        $carAr = ArrayHelper::map($cat,'categoryId','categoryName');
                        $carArtt = ArrayHelper::map($cat,'categoryId','isAvailableForAllClients');

                        $subcat = SubcategoryMaster::find()->where(['activeStatus'=>'A'])->asArray()->all();
                        $subcarAr = ArrayHelper::index($subcat,'subcategoryId','categoryId');

                        $iscateChecked = $isSubScatChecked = 'checked';
                        $updatedCatAr = $updatedSubCatAr = array();
                        $isNew = "yes";
                        if($model->restrictedCategories!="" && $model->restrictedCategories!=NULL){
                            $isNew = "no";
                            $updatedCatAr = ArrayHelper::toArray(json_decode($model->restrictedCategories));
                        }if($model->restrictedsubCategories!="" && $model->restrictedsubCategories!=NULL){
                            $isNew = "no";
                            $updatedSubCatAr = ArrayHelper::toArray(json_decode($model->restrictedsubCategories));
                        }
                        // echo "<prE>";print_r($updatedSubCatAr);die;
                        $content = "";
                        if(!empty($carAr)){
                            $content .= '<ul>';
                            foreach ($carAr as $catId => $catOne) {
                                $isAvailableForAllClients = "";
                                if (array_key_exists($catId, $carArtt)) {
                                    # code...
                                    $isAvailableForAllClients = $carArtt[$catId];
                                }
                                
                                if($isNew=='no'){
                                    $iscateChecked = "";
                                    if(in_array($catId, $updatedCatAr)){
                                        $iscateChecked = 'checked';
                                    }
                                }else{
                                    if($isAvailableForAllClients=="no"){
                                        $iscateChecked = "";
                                    }                                    
                                }
                                $content .= '<li>';
                                    $content .= '<input name="cateIds[]" value="'.$catId.'"  type="checkbox" '.$iscateChecked.' />'.$catOne.' ';
                                    if(array_key_exists($catId, $subcarAr)){
                                        if(!empty($subcarAr[$catId])){
                                            $content .= '<ul>';
                                            foreach ($subcarAr[$catId] as $key => $oneList) {
                                                if($isNew=='no'){
                                                    $isSubScatChecked = "";
                                                    if(in_array($oneList["subcategoryId"], $updatedSubCatAr)){
                                                        $isSubScatChecked = "checked";
                                                    }
                                                }else{
                                                    if($oneList['isAvailableForAllClients']=="no"){
                                                        $iscateChecked = "";
                                                    }                                    
                                                }
                                                $content .= '<li><input name="subcateIds[]" value="'.$oneList["subcategoryId"].'" type="checkbox" '.$isSubScatChecked.' />'.$oneList['subcategoryName'].'</li>'; 
                                            }
                                            $content .= '</ul>';
                                        }
                                    }
                                $content .= '</li>';
                            }
                            $content .= '</ul>';
                        }
                        echo $content;
                    ?>
