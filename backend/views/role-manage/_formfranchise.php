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
use backend\models\AuthProjectRights;
/* @var $this yii\web\View */
/* @var $model backend\models\RoleManage */
/* @var $form yii\widgets\ActiveForm */

//$RoleManage_not_user=ArrayHelper::map(RoleManage::find()->asArray()->all(),'user_name','user_name');

$dropdown_management=ArrayHelper::map(DropdownManagement::find()->where(['key'=>'module-show-status'])->andWhere(['is_active'=>'1'])->asArray()->all(),'id','id');

$session = Yii::$app->session;

?>

<style type="text/css">
  .form-text.form-checkbox:not(.btn), .form-text.form-radio:not(.btn) {
    padding-left: 25px;
}

.form-checkbox:not(.btn), .form-radio:not(.btn) {
    padding: 10px;
        padding-left: 10px;
}

.form-checkbox:not(.btn), .form-radio:not(.btn) {
    display: inline-block;
    display: block;
    background-color: 
    transparent;
    border: 0;
    position: relative;
    padding: 3px 3px 3px 25px;
    line-height: 1em;
    min-width: 19px;
    margin: 0;
}

.more_auth{
  color:#ba2967;
font-size: 14px;

}

</style>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>

<?php 
$in_module = json_decode($model->role_service,true);
//$in_options= json_decode($model->role_rights,true);

//echo "<pre>";
//print_r($in_module);die;

$checkedservice = array();
$checkboxList='';

$is_checked='';
if(!$model->isNewRecord)
{

}




$services_all=AuthProjectModule::find()->where(['is_active'=>'1'])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();


$services_all_one=AuthProjectModule::find()->where(['is_active'=>'1'])->andWhere(['IN','moduleMultiple',['one','more']])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();


$auth_project_rights=AuthProjectRights::find()->where(['active_status'=>'1'])->andWhere(['module_rights'=>'60'])->andWhere(['IN','auth_module_id',ArrayHelper::getColumn($services_all_one,'p_autoid')])->indexBy('id')->asArray()->all();

$auth_project_rights_index=ArrayHelper::index($auth_project_rights,'module_rights','auth_module_id');


$services=AuthProjectModule::find()->where(['is_active'=>'1'])->andWhere(['IN','p_autoid',ArrayHelper::getColumn($auth_project_rights,'auth_module_id')])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();


$services_all_index_identity=AuthProjectModule::find()->where(['is_active'=>'1'])->andWhere(['moduleMultiple'=>'identify'])->andWhere(['IN','p_autoid',ArrayHelper::getColumn($services,'moduleCode2')])->indexBy('p_autoid')->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();



$services_all_index_one=AuthProjectModule::find()->where(['is_active'=>'1'])->andWhere(['IN','p_autoid',ArrayHelper::getColumn($services,'p_autoid')])->andWhere(['moduleMultiple'=>'one'])->indexBy('p_autoid')->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();

$services_all_index_one_index=ArrayHelper::index($services_all_index_one,'p_autoid','moduleCode2');

$services_all_index_more=AuthProjectModule::find()->where(['is_active'=>'1'])->andWhere(['IN','p_autoid',ArrayHelper::getColumn($services,'p_autoid')])->andWhere(['moduleMultiple'=>'more'])->indexBy('p_autoid')->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();

$services_all_index_more_index=ArrayHelper::index($services_all_index_more,'p_autoid','moduleCode2');



$services_all_index_sub=AuthProjectModule::find()->where(['is_active'=>'1'])->andWhere(['IN','moduelRoot',ArrayHelper::getColumn($services_all_index_more,'p_autoid')])->andWhere(['moduleMultiple'=>'sub'])->indexBy('p_autoid')->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();

$services_all_index_sub_index=ArrayHelper::index($services_all_index_sub,'p_autoid','moduleCode3');

//echo "<pre>";
//print_r($services_all_index_sub_index);die;

$html='';
$common_increment=1;


$identify_id=1;
$more_rights_id=1;
$sub_rights_id=1;
foreach($services_all_index_identity as $key => $value) 
{

  /*if(array_key_exists($value['p_autoid'], $auth_project_rights_index))
  {
      if(array_key_exists(60, $auth_project_rights_index[$value['p_autoid']]))
      {

      }
      else
      {
          continue;
      }
  }
  else
  {
      continue;
  }*/



  $is_checked='';
  

    if($value['moduleMultiple'] == 'identify')
    {
        if(array_key_exists($value['p_autoid'], $services_all_index_identity))
        {

            if(is_array($in_module)>0)
            {
              if(in_array($services_all_index_identity[$value['p_autoid']]['p_autoid'], $in_module))
              {
                  $is_checked='checked';
              }
            }

            $html.='<div class="card-body">
                          <div class="accordion" id="accordion-'.$common_increment.'">
                            <div class="card">
                              <h5 class="card-title">
                                <a class="col-sm-3" data-toggle="collapse" data-parent="#accordion-'.$common_increment.'" href="#collapse-'.$common_increment.'">'.$services_all_index_identity[$value['p_autoid']]["moduleName"].' </a>
                                
                                '.Html::checkbox('RoleManage[role_service][]',$is_checked,['value' =>$services_all_index_identity[$value['p_autoid']]['p_autoid'],'label' => false,'class'=>['form-checkbox form-icon form-text active col-sm-2 identify'],'identify-id'=>$identify_id,'id'=>'identify-id'.$identify_id]).'
                              </h5>
                              <div id="collapse-'.$common_increment.'" class="collapse show">
                              ';



            if(array_key_exists($value['p_autoid'], $services_all_index_one_index))
            {
                  foreach ($services_all_index_one_index[$value['p_autoid']] as $key_one => $value_one) 
                  {
                     $is_checked='';
                    if(is_array($in_module)>0)
                    {
                      if(in_array($value_one["p_autoid"], $in_module))
                      {
                          $is_checked='checked';
                      }
                    }



                      $html.='
                                <div class="card-body">
                                  
                                  '.Html::checkbox('RoleManage[role_service][]',$is_checked,['value' =>$value_one["p_autoid"],'label' => $value_one["moduleName"],'class'=>['more_auth form-checkbox form-icon form-text active col-sm-2 more_rights'],'identify-id'=>$identify_id,'more_rights'=>$more_rights_id,'id'=>'more_rights'.$more_rights_id]).'

                                
                                </div>
                              ';

                              $more_rights_id++;
                  }
                  
            }
            
            if(array_key_exists($value['p_autoid'], $services_all_index_more_index))
            {   
                  foreach ($services_all_index_more_index[$value['p_autoid']] as $key_more => $value_more) 
                  { 
                      $is_checked='';
                    if(is_array($in_module)>0)
                    {
                      if(in_array($value_more["p_autoid"], $in_module))
                      {
                          $is_checked='checked';
                      }
                    }



                      $html.='
                                <div class="card-body">

                                  '.Html::checkbox('RoleManage[role_service][]',$is_checked,['value' =>$value_more["p_autoid"],'label' => $value_more["moduleName"],'class'=>['more_auth more_rights'],'identify-id'=>$identify_id,'more_rights'=>$more_rights_id,'id'=>'more_rights'.$more_rights_id]).'
                                  
                                
                              ';

                      if(array_key_exists($value_more['p_autoid'], $services_all_index_sub_index))   
                      {
                        $html.='<div class="row ml-10">';
                          foreach ($services_all_index_sub_index[$value_more['p_autoid']] as $key_sub => $value_sub) 
                          {

                              $is_checked='';
                              if(is_array($in_module)>0)
                              {
                                if(in_array($value_sub["p_autoid"], $in_module))
                                {
                                    $is_checked='checked';
                                }
                              }

                                $html.='
                                 
                                  <div class="col-sm-4">
                                  '.Html::checkbox('RoleManage[role_service][]',$is_checked,['value' =>$value_sub["p_autoid"],'label' => $value_sub["moduleName"],'identify-id'=>$identify_id,'more_rights'=>$more_rights_id,'sub_rights_id'=>$sub_rights_id,'class'=>['sub-rights']]).'
                                  
                                 
                                  </div>  
                                
                                
                              ';
                              $sub_rights_id++;
                          }
                           $html.="</div>";

                          
                      }

                      $html.="</div><hr>";
                         $more_rights_id++;
                  }
                    
                    
            }

            $html.='</div></div>
                          </div>
                        </div>';
            $common_increment++;
            $identify_id++;
        }
    }
    else
    {
          continue;
    }
}



?>
<!-- <div class="col-sm-12">
 --> 
 <div class="card">
              <h4 class="card-title"><strong>Role Manage</strong></h4>
              <!-- <div class="card-body">
                <div class="col-sm-4">
                <div class="custom-controls-stacked">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="cc-1">
                    <label class="custom-control-label" for="cc-1">Unchecked</label>
                  </div>
                </div>
              </div>
            </div> -->
                <?php echo $html;?>
            </div>
<!-- </div>
 -->
<div class='col-sm-12 form-group' >
    <ul style="color:#ba2967;border-bottom: 1px solid;"></ul>
</div>
      <div class="col-sm-12 form-group">

    <!-- <div class="col-sm-4 <?php echo ($session['master_type'] == 'F') ? 'hide' : ''?>">
     
     <?php
    /*
      if(!$model->isNewRecord)
      {
            echo Html::checkbox('RoleManage[update-franchise]','',['label'=>'Update Existing Franchise','name'=>'RoleManage[update-franchise]']);
      }
    */
     ?>
   </div> -->

    <div class="col-sm-2 pull-right">

        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
   </div>

    <?php //echo $form->field($model, 'status')->dropDownList([ 'A' => 'A', 'I' => 'I', ], ['prompt' => '']) ?>

    <?php ActiveForm::end(); ?>



   <script type="text/javascript">
     $(document).ready(function(){

        $('.identify').click(function(){
            var identify=$(this).attr('identify-id');
            //alert(1);
            if($(this).prop("checked") == true){  
                $('input[identify-id="'+identify+'"]').prop("checked", true);  
              
                   
               }else if($(this).prop("checked") == false){ 
               $('input[identify-id="'+identify+'"]').prop("checked", false);
                
              }
        });

        $('.more_rights').click(function(){
            var more_rights=$(this).attr('more_rights');

            var identify=$(this).attr('identify-id');
            $('#identify-id'+identify).prop("checked", false);
            if($(this).prop("checked") == true)
            {  
                $('input[more_rights="'+more_rights+'"]').prop("checked", true);  
            }
            else if($(this).prop("checked") == false)
            { 
                $('input[more_rights="'+more_rights+'"]').prop("checked", false);
            }

            selectall(identify);
        });

        $('.sub-rights').click(function(){
            var more_rights=$(this).attr('more_rights');

            var identify=$(this).attr('identify-id');

            var sub_rights_id=$(this).attr('sub_rights_id');
            
            $('#identify-id'+identify).prop("checked", false);
            $('#more_rights'+more_rights).prop("checked", false);

           /* if($(this).prop("checked") == true)
            {  
                //$('input[more_rights="'+more_rights+'"]').prop("checked", true);  
                $('#identify-id'+identify).prop("checked", true);
                $('#more_rights'+more_rights).prop("checked", true);
            }
            else if($(this).prop("checked") == false)
            { 
                //$('input[more_rights="'+more_rights+'"]').prop("checked", false);
                $('#identify-id'+identify).prop("checked", false);
                $('#more_rights'+more_rights).prop("checked", false);
            }*/

            selectallrights(more_rights);
        });

     });

    function selectall(identify)
    {
        var favorite1 = [];
        var op1=0;

        
        $.each($('input[identify-id="'+identify+'"]'), function(){
            
            if($(this).prop("checked") == true)
            {   
              favorite1.push(op1);
                  op1++;
            }
           
        });

         
        if(favorite1.length >= 1)
        {
          
             $('#identify-id'+identify).prop("checked", true);
        }
        else
        { 

             $('#identify-id'+identify).prop("checked", false);
        }
    }

    function selectallrights(more_rights)
    {
        var favorite1 = [];
        var op1=0;

        
        $.each($('input[more_rights="'+more_rights+'"]'), function(){
            
            if($(this).prop("checked") == true)
            {   
              favorite1.push(op1);
                  op1++;
            }
           
        });

         
        if(favorite1.length >= 1)
        {
          
             $('#more_rights'+more_rights).prop("checked", true);

             var identify=$('#more_rights'+more_rights).attr("identify-id");
            // $('#identify-id'+identify).prop("checked", true);
              selectall(identify);
        }
        else
        { 

             $('#more_rights'+more_rights).prop("checked", false);

             var identify=$('#more_rights'+more_rights).attr("identify-id");
            // $('#identify-id'+identify).prop("checked", false);
              selectall(identify);
        }
    }
   </script>

