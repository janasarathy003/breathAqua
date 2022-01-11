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

//$RoleManage_not_user=ArrayHelper::map(RoleManage::find()->asArray()->all(),'user_name','user_name');

$dropdown_management=ArrayHelper::map(DropdownManagement::find()->where(['key'=>'module-show-status'])->andWhere(['is_active'=>'1'])->asArray()->all(),'id','id');

$session = Yii::$app->session;

?>

<div class="serviceuser-login-form">
<div class="panel panel-primary">
<div class="panel-body">
    <?php $form = ActiveForm::begin(); ?>
 <div class="row">








  <div class="col-sm-4">
    <!-- <?/*= $form->field($model, 'user_name')->dropDownList(
      ArrayHelper::map(UserLogin::find()->where([$model->isNewRecord ? 'NOT IN' : 'IN','id',$RoleManage_not_user])->all(),'id','staff_name')
  ,['prompt'=>'--SELECT--','required'=>true]) */?>   -->


  <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
  </div>  
  </div> 
  <?php 
$in_module = json_decode($model->role_service,true);
$in_options= json_decode($model->role_rights,true);
//$services = AuthProjectModule::find()->select('p_autoid,moduleName,moduleMultiple,user_rights')->where(['IN','p_autoid',$in_module])->all();

$checkedservice = array();
$checkboxList='';
$services_all=AuthProjectModule::find()->where(['is_active'=>'1'])->orderBy(['sortOrder'=>SORT_ASC])->asArray()->all();

//$services_all_index=ArrayHelper::index($services_all,'moduelRoot','p_autoid','moduleMultiple');

/*$services_all_index = ArrayHelper::index($services_all, 'p_autoid', [function ($element) {
    return $element['sortOrder'];
},'moduleMultiple']);*/



//echo "<pre>";print_r($services_all_index);die;
$common_array=array('V'=>'View','C'=>'Create','E'=>'Update','D'=>'Delete','A'=>'Approve','P'=>'Print','U'=>'Upload','I'=>'Import');
$count=count($common_array);
$est=1;
$estdata=1;
$data_inv=1;
foreach($services_all as $key1=>$val123) {


  $show_rights=json_decode($val123['module_show_status']);

  if($session['master_type'] == 'F')
  {
      if(!empty($show_rights))
      {
        $show_rights=array_fill_keys($show_rights,true);

        if(!array_key_exists(60, $show_rights))
        {
            continue;
        }
      }
  }

  

  if($val123['moduleMultiple']=='identify'){
    continue;
  }
  $checkboxList.='<tr>';
  
  $is_checked='';
  if(is_array($in_module)>0){
  if(in_array($val123['p_autoid'], $in_module)){
    
     $is_checked='checked';
  }
  }
  $allj='';
  $idg=$val123['p_autoid'];
  $class='';
  $ins_name='';
 
  if($val123['moduleMultiple']=='sub' ){
    $allj=$idg;
    $checkboxList.='<td>&nbsp;</td>';
    $class='gs ds';
    $ins_name='invv';
    $module_root=$val123['moduelRoot'];

    $modeule_name=$val123['moduleName'];

    $modeule_name_root='sub_'.$val123['moduelRoot'];

    $checkboxList.='<td>'.Html::checkbox('RoleManage[role_service][]',$is_checked,['value' =>$val123['p_autoid'],'label' => $modeule_name,'class'=>[$class],'data-est'=>$est,'data-id'=>$idg,'data-mst'=>$allj,'data-all'=>1,'data-inv'=>$data_inv,'data-inv2'=>$ins_name.$allj,'moduleroot'=>$module_root,'moduleroot_name'=>$modeule_name_root] ).'</td>'; 
  
  }else if($val123['moduleMultiple']=='more'){
    $allj=$idg;
    $class='gs';
    $ins_name='invo';
    $module_root=$val123['moduelRoot'];
    $modeule_name=$val123['moduleName'];
     $modeule_name_root='more_'.$val123['moduelRoot'];

       $checkboxList.='<td>'.Html::checkbox('RoleManage[role_service][]',$is_checked,['value' =>$val123['p_autoid'],'label' => $modeule_name,'class'=>[$class],'data-id'=>$idg,'data-mst'=>$allj,'data-all'=>1,'data-inv'=>$data_inv,'data-inv2'=>$ins_name.$allj,'moduleroot'=>$module_root,'moduleroot_name'=>$modeule_name_root] ).'</td>'; 
  }
  else if($val123['moduleMultiple']=='one')
  {
    $allj=$idg;
    $class='gs';
    $ins_name='invo';
    $module_root='';
     // $checkboxList.='<td>&nbsp;</td>';
    $modeule_name=$val123['moduleName']; 
    $modeule_name_root='one_'.$val123['moduelRoot'];  

      $checkboxList.='<td>'.Html::checkbox('RoleManage[role_service][]',$is_checked,['value' =>$val123['p_autoid'],'label' => $modeule_name,'class'=>[$class],'data-est'=>$est,'data-id'=>$idg,'data-mst'=>$allj,'data-all'=>1,'data-inv'=>$data_inv,'data-inv2'=>$ins_name.$allj,'moduleroot'=>$module_root,'moduleroot_name'=>$modeule_name_root] ).'</td>'; 

  }
  
  
   
  
 /* if($val123['moduleMultiple']=='one')
  {
    $checkboxList.='<td>&nbsp;</td>';
  }*/

  $option_array=json_decode($val123['user_rights']);
 
  
  if($val123['moduleMultiple']=='sub' || $val123['moduleMultiple']=='one'){  
   if(!empty($option_array))
   {
    foreach($option_array as $one_option){
    $is_option_checked='';
    if(isset($in_options[$idg])){
       if(in_array($one_option,$in_options[$idg])){
        $is_option_checked='checked';
      }
    }
    $checkboxList.='<td>'.Html::checkbox('option_'.$idg.'[]',$is_option_checked,['value' =>$one_option,'label' => $common_array[$one_option],'class'=>['data data'.$est.''],'id'=>'find'.$estdata.'','dataiop'=>$estdata,'data-vst'=>$est,'data-mst'=>$allj,'data-all'=>1,'data-inv1'=>$allj,'moduleroot'=>$module_root,'moduleroot_name'=>'under_check'.$module_root] ).'</td>';
    $estdata++;
  }
   } 
    $est++; $data_inv++;


  }else{
   $checkboxList.='<td colspan='.$count.'></td>'; 
  }
}
?>

<div class="row">
   <table class="table table-condensed">
     <thead>
       <tr>
      <th ><input type="checkbox" name="s_all" id="s_all">&nbsp;Select All</th>
      
         <th>Role</th>
         <!--th>Create</th>
         <th>Edit</th>
         <th>Delete</th-->
         <!--th></th><th></th><th></th>
         <th></th-->
        <?php
       
          echo '<th colspan='.$count.'></th>';
           /* if(!empty($common_array))
            {
                foreach($common_array as $key => $value)
                {
                  echo '<th></th>';
                }
            }*/
        ?>

       </tr>
     </thead>
<?php echo $checkboxList; ?>

   </table>
</div>  


<div class='col-sm-12 form-group' >
    <ul style="color:#ba2967;border-bottom: 1px solid;"></ul>
</div>


      <div class="col-sm-12">

    <div class="col-sm-4 <?php echo ($session['master_type'] == 'F') ? 'hide' : ''?>">
     
     <?php

      if(!$model->isNewRecord)
      {
            echo Html::checkbox('RoleManage[update-franchise]','',['label'=>'Update Existing Franchise','name'=>'RoleManage[update-franchise]']);
      }

     ?>
   </div>

    <div class="col-sm-4">

        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


   </div>

    <?php //echo $form->field($model, 'status')->dropDownList([ 'A' => 'A', 'I' => 'I', ], ['prompt' => '']) ?>

    <div class="form-group">
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>


    <script type="text/javascript">

        function selectall()
        {
            var op=0
            var opp=0;
            $.each($('input[data-all="1"]'), function(){
                
                if($(this).prop("checked") == true)
                {   
                  op++;
                }
                
                opp++;
            });

            if(op === opp)
            {
                 $('input[id="s_all"]').prop("checked", true);
            }
            else
            { 
                 $('input[id="s_all"]').prop("checked", false);
            }
        }


        $(document).ready(function(){
            $('input[id="s_all"]').click(function(){
               if($(this).prop("checked") == true){  
                //$('.gs').prop("checked", true);  
                $('input[data-all="1"]').prop("checked", true);    
               }else if($(this).prop("checked") == false){ 
                $('input[data-all="1"]').prop("checked", false);    
              }
            });
            $('input[class="gs"]').click(function(){
               var rid=$(this).attr('moduleroot_name');

               if(rid === 'one_')
               {
                  var data_est=$(this).attr('data-est');

                   if($('input[data-est="'+data_est+'"]').prop("checked") == true)
                   {  
                      $('input[data-vst="'+data_est+'"]').prop("checked", true);  
                   }
                   else if($('input[data-est="'+data_est+'"]').prop("checked") == false)
                   { 
                      $('input[data-vst="'+data_est+'"]').prop("checked", false); 
                   }
               }
               else
               {
                  var rid=$(this).attr('moduleroot');
                  if($(this).prop("checked") == true)
                  {  
                      $('input[moduleroot="'+rid+'"]').prop("checked", true); 
                      $('input[moduleroot="'+rid+'"]').prop("checked", true);     
                  }
                  else if($(this).prop("checked") == false)
                  { 
                      $('input[moduleroot="'+rid+'"]').prop("checked", false);   
                      $('input[moduleroot="'+rid+'"]').prop("checked", false);    
                  }
               }
                selectall();
            });

            $('input[class="gs ds"]').click(function(){
               var rid=$(this).attr('data-est');
               var invo=$(this).attr('data-mst');
               var data_inv=$(this).attr('moduleroot');
               
               if($(this).prop("checked") == true){  
                $('input[data-vst="'+rid+'"]').prop("checked", true);  
                $('input[data-inv2="invo'+invo+'"]').prop("checked", true); 
                   
               }else if($(this).prop("checked") == false){ 
                $('input[data-vst="'+rid+'"]').prop("checked", false); 
                $('input[data-inv2="invo'+invo+'"]').prop("checked", false); 
                 
              }

            var favorite = [];
            var op=0
            $.each($('input[moduleroot_name="sub_'+data_inv+'"]'), function(){
                var riddata=$(this).attr('moduleroot');
                if($(this).prop("checked") == true){  
                  favorite.push(op);
                  op++;

               }
            });

            if(favorite.length >= 1)
            {
                 $('input[moduleroot_name="more_'+data_inv+'"]').prop("checked", true);
            }
            else
            { 
                 $('input[moduleroot_name="more_'+data_inv+'"]').prop("checked", false);
            }

            selectall();
            });

            $('.data').click(function(){
               
               var rid=$(this).attr('data-vst');
               var invo=$(this).attr('data-inv1');

               var module_name=$(this).attr('moduleroot');
               
               //if($(this).prop("checked") == true)
               var favorite = [];
               var op=0;
               //var favorite_data = [];
               $.each($('input[moduleroot_name="under_check'+module_name+'"]'), function(){
               var riddata=$(this).attr('moduleroot');
                if($(this).prop("checked") == true){  
                  favorite.push(op);
                  op++;

               }
            });
           
            if(favorite.length >= 1)
            {
                $('input[moduleroot_name="more_'+module_name+'"]').prop("checked", true);
            }
            else
            { 
              $('input[moduleroot_name="more_'+module_name+'"]').prop("checked", false);
             
            }

            var favorite1 = [];
               var op1=0;
               //var favorite_data = [];
               $.each($('input[data-vst="'+rid+'"]'), function(){
               
                if($(this).prop("checked") == true){  
                  favorite1.push(op);
                  op1++;

               }
            });


            if(favorite1.length >= 1)
            {
                $('input[data-est="'+rid+'"]').prop("checked", true);
            }
            else
            { 
              $('input[data-est="'+rid+'"]').prop("checked", false);
             
            }
            selectall();
          });

        });

    </script>

