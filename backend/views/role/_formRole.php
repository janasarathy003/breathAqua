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
  <ol class="breadcrumb invisible">
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
        <h3> Only Selected Functionalities are Allowed to that Role based Users </h3>
        <?php 
          $content = "";
          if(!empty($leftMenuData)){
              $content .= '<ul >';
              foreach ($leftMenuData as $catId => $oneMenu) {
                  $isMenuChecked = $isSubMenuChecked = "";
                  if(!empty($resAr)){
                    if(array_key_exists('menu', $resAr)){
                      if(!empty($resAr['menu'])){
                        if(in_array($oneMenu['menuId'], $resAr['menu'])){
                          $isMenuChecked = "checked";
                        }                                              
                      }
                    }
                  }
                  $content .= '<li>';
                  $content .= '<label class="custom-control custom-checkbox"><input class="custom-control-input selectall" data-group="'.$oneMenu['menuId'].'" name="cateIds[]" value="'.$oneMenu['menuId'].'"  type="checkbox" '.$isMenuChecked.' />
                    <span class="custom-control-label">'.$oneMenu['Name'].'</span></label>';
                  // array_key_exists(key, array)
                  // echo "<pre>";print_r($leftMenuData);die;
                  if(array_key_exists( $oneMenu['groupId'],$leftMenuDataSub) && !empty($leftMenuDataSub[$oneMenu['groupId']])){
                    
                          $content .= '<ul class="ml-6 list-group">';
                      foreach ($leftMenuDataSub[$oneMenu['groupId']] as $key => $oneSubMenu) {
                          $isSubMenuChecked = "";
          
                          if(!empty($resAr)){
                            if(array_key_exists('submenu', $resAr)){
                              if(!empty($resAr['submenu'])){
                                
                                if(in_array($oneSubMenu['menuId'], $resAr['submenu'])){
                                  
                                    $isSubMenuChecked = "checked";
                                }
                              }
                            }
                        }
          
                          $content .= '<li class="listorder" style="border:unset;list-style-type: unset;"><label class="custom-control custom-checkbox" style="display:revert;"><input class="custom-control-input child" data-group="'.$oneMenu['groupId'].'"  name="subcateIds[]" value="'.$oneSubMenu["menuId"].'" type="checkbox" '.$isSubMenuChecked.' /><span class="custom-control-label">'.$oneSubMenu['Name'].'</span></label></li>'; 
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
      <?= Html::a('<i class="fa fa-close"></i> Close', ['index'], ['class' => 'btn btn-outline-primary ','title'=>'Close'])?>
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
  </div>
  <style>				    
    input[type="checkbox"] {
    transform: scale(1.5);
    -webkit-transform: scale(1.5);
    }
  </style>
  <script> (function($){       
    $('.child').change(function(){       
    var group = $(this).data('group'),    
    checkall = $('.selectall[data-group="'+group+'"]');    
    var someChecked = $('.child[data-group="'+group+'"]:checkbox:checked').length > 0;   
    var someUnchecked = $('.child[data-group="'+group+'"]:checkbox:not(:checked)').length > 0;  
    checkall.prop("indeterminate", someChecked && someUnchecked);     
    checkall.prop("checked", someChecked || !someUnchecked);         
    }).change();          
    $('.selectall').click(function() {      
    var group = $(this).data('group');   
    $('.child[data-group="'+group+'"]').prop('checked', this.checked).change();  
    });}(window.jQuery));
  </script>					  				  
  <?php ActiveForm::end(); ?> 
  <style>
    .table thead th {
    vertical-align: middle!important;
    }
    .table-sm th {
    }.table th, .text-wrap table th{
    /*	font-size:.65rem; */
    text-transform:capitalize;
    }
    table input[type="checkbox"] {
    transform: unset;
    -webkit-transform: unset;
    }
    .table > thead > tr > th,
    .table > tbody > tr > th, 
    .table > tfoot > tr > th, 
    .table > thead > tr > td, 
    .table > tbody > tr > td, 
    .table > tfoot > tr > td{
    /* vertical-align:middle;padding: 10px 5px; */
    }
  </style>
  <link href="https://dev.hirephpcoder.com/firstman_dev/backend/web/css/jquery-stickytable.css">
  <!--<div class="col-sm-12"> Jana
    <div class="card">
      <div class="card-body">
        <div class="table-scrollable"  >
          <!--  <table cellspacing="10"  cellpadding="10" class="table table-sm table-bordered table-striped text-center" style="height:200px;"  >
            <thead>
              <tr>
                <th rowspan="2">Actions</th>
                <th rowspan="2">Dashboard</th>
                <th colspan="3" class="text-center">Admin User Management</th>
                <th rowspan="2">Shop Category Management</th>
                <th colspan="2">Merchant Package Management</th>
                <th rowspan="2">Merchant List</th>
                <th rowspan="2">Shopee List</th>
                <th rowspan="2">Merchant Profile Update</th>
                <th rowspan="2">Package Selection</th>
                <th rowspan="2">Overall Offer Management</th>
                <th rowspan="2">Product Management</th>  
                <th rowspan="2">Payment History</th>  
                <th rowspan="2">Renewal Management</th>  
                <th rowspan="2">Plan change request Management</th>  
            
            
               
                
                 
              </tr>
              <tr>
                 
               
                <th>Menu Management</th>
                <th>Role management</th>
                <th>Admin User's List</th>
                  <th>Package Master</th>
                <th>Package Limitations</th>  
                
               
                 
                
              </tr>
            <tr style="background-color:#fff;color:#000;">
            <th class='{sorter: false}' ><input type="checkbox" class=" " id="selectall"  > <br> All</th>
            <th class='{sorter: false}'><input type="checkbox" class="  " id="select_col_0"/> <br>Select All</th>
            <th class='{sorter: false}'><input type="checkbox" class=" " id="select_col_1"/> <br>Select All</th>
            <th class='{sorter: false}'><input type="checkbox" class=" " id="select_col_2"/> <br>Select All</th>
            <th class='{sorter: false}'><input type="checkbox" class=" " id="select_col_3"/><br> Select All</th>
            <th class='{sorter: false}'>  <input type="checkbox" class=" " id="select_col_4"/><br>Select All</th>
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_5"/><br> Select All</th>
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_6"/><br> Select All</th>
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_7"/> <br>Select All</th>
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_8"/><br> Select All</th>
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_9"/><br> Select All</th>
            <th class='{sorter: false}'>  <input type="checkbox" class=" " id="select_col_10"/><br>Select All</th>
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_11" ><br> Select All</th>
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_12"/><br> Select All</th>  
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_13"/><br> Select All</th>  
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_14"/><br> Select All</th>  
            <th class='{sorter: false}'> <input type="checkbox" class=" " id="select_col_15"/><br> Select All</th>  
            </tr>
            
            
            
            
            
            </thead>
            <tbody>
              <tr>
                 <th >   
            <span class="co-name"> <input type="checkbox" class=" " id="select_row_0"><br> View</span>
            </th>
            <th><input type="checkbox" class=" checkBoxClass row_0 col_0 "  > </th>
            <th ><input type="checkbox" class="checkBoxClass row_0 col_1  "  > </th>
            <th><input type="checkbox" class=" checkBoxClass row_0 col_2 "  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_3"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_4"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_5"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_6"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_7"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_8"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_9"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_10"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_11"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_12"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_13"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_14"  > </th>
            <th ><input type="checkbox" class=" checkBoxClass row_0 col_15"  > </th>
            
            </tr>
            <tr>
            <th><span class="co-name"><input type="checkbox" id="select_row_1"> <br> Add</span></th>
                    <th><input type="checkbox" class="checkBoxClass row_1 col_0 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_1 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_2 " > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_3 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_4 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_5 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_6 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_7 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_8 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_9 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_10 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_11 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_12 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_13 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_14 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_1 col_15 "  > </th>
            
            </tr>
            <tr><th><span class="co-name"><input type="checkbox" class=" " id="select_row_2"><br> Delete</span></th> 
            
            <th><input type="checkbox" class="checkBoxClass row_2 col_0 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_1 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_2 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_3 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_4 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_5 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_6 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_7 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_8 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_9 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_10 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_11 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_12 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_13 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_14 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_2 col_15 "  > </th>
            
            </tr>
            <tr><th><span class="co-name"><input type="checkbox" id="select_row_3"><br> Update</span></th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_0 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_1 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_2 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_3 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_4 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_5 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_6 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_7 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_8 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_9 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_10 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_11 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_12 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_13 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_14 "  > </th>
            <th><input type="checkbox" class="checkBoxClass row_3 col_15 "  > </th>
            
            </tr>
            
            </tbody>
            
            </table> -->  
            <!-- Jana 
          <table cellspacing="10"  cellpadding="10" class="table table-sm table-bordered  text-center">
            <thead>
              <tr>
                <th style="width:80px;" class='{sorter: false} text-center' > Select All<br>   <input type="checkbox" class=" " id="selectall">   </th>
                <th>Menu   </th>
                <th class='{sorter: false}'>Add <br> <input type="checkbox" class="  " id="select_col_0"/> </th>
                <th class='{sorter: false}'>View <br> <input type="checkbox" class="  " id="select_col_1"/>   </th>
                <th class='{sorter: false}'>Edit  <br><input type="checkbox" class="  " id="select_col_2"/>   </th>
                <th class='{sorter: false}'>Delete  <br><input type="checkbox" class="  " id="select_col_3"/>   </th>
              </tr>
              <tr>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="text-center">   
                  <span class="co-name "> <input type="checkbox"  id="select_row_0">   </span>
                </th>
                <th class="text-left">Dashboard</th>
                <th><input type="checkbox" class=" checkBoxClass row_0 col_0"> </th>
                <th><input type="checkbox" class="checkBoxClass row_0 col_1"> </th>
                <th><input type="checkbox" class="checkBoxClass row_0 col_2"> </th>
                <th><input type="checkbox" class="checkBoxClass row_0 col_3"> </th>
              </tr>
              <tr>
                <th class='{sorter: false} text-center'> <input type="checkbox" class="" id="select_row_1"/>   </th>
                <th class="text-left">User Management</th>
                <th><input type="checkbox" class="checkBoxClass row_1 col_0"  > </th>
                <th ><input type="checkbox" class="checkBoxClass row_1 col_1"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_1 col_2"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_1 col_3"  > </th>
              </tr>
			   
			  <tr>
                 <td colspan="9" class="text-left"><b>Admin User Management</b></td>
              </tr>
			   <tr>
                <th class='{sorter: false} text-center'> <input type="checkbox" class="" id="select_row_2"/>   </th>
                <th class="text-left">Menu Management</th>
                <th><input type="checkbox" class="checkBoxClass row_2 col_0"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_2 col_1"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_2 col_2"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_2 col_3"  > </th>
              </tr>
			  <tr>
                <th class='{sorter: false} text-center'> <input type="checkbox" class="" id="select_row_3"/>   </th>
                <th class="text-left">Role Management</th>
                <th><input type="checkbox" class="checkBoxClass row_3 col_0"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_3 col_1"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_3 col_2"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_3 col_3"  > </th>
              </tr>
			  <tr>
                <th class='{sorter: false} text-center'> <input type="checkbox" class="" id="select_row_4"/>   </th>
                <th class="text-left">Admin User's List</th>
                <th><input type="checkbox" class="checkBoxClass row_4 col_0"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_4 col_1"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_4 col_2"  > </th>
                <th><input type="checkbox" class="checkBoxClass row_4 col_3"  > </th>
              </tr>
			  
            </tbody>
          </table> 
        </div> 
      </div>
    </div>
  </div> -->
</div>
<!--  
  <script src="https://dev.hirephpcoder.com/firstman_dev/backend/web/js/jquery-stickytable.js"></script>
  <script src="https://dev.hirephpcoder.com/firstman_dev/backend/web/js/freeze-table.js"></script>   --> 
<script>
  //$('.table-scrollable').freezeTable('resize');
  // $(".table-scrollable").freezeTable({
  // 'scrollable': true,
  // });  
</script>
<script type="text/javascript">
  function getRegexMatches(regex, string) {
      if(!(regex instanceof RegExp)) {
          return "ERROR";
      }
      else {
          if (!regex.global) {
              // If global flag not set, create new one.
              var flags = "g";
              if (regex.ignoreCase) flags += "i";
              if (regex.multiline) flags += "m";
              if (regex.sticky) flags += "y";
              regex = RegExp(regex.source, flags);
          }
      }
      var matches = [];
      var match = regex.exec(string);
      while (match) {
          if (match.length > 2) {
              var group_matches = [];
              for (var i = 1; i < match.length; i++) {
                  group_matches.push(match[i]);
              }
              matches.push(group_matches);
          }
          else {
              matches.push(match[1]);
          }
          match = regex.exec(string);
      }
      return matches;
  }
  
  /**
   * get the select_row or select_col checkboxes dependening on the selectType row/col
   */
  function getSelectCheckboxes(selectType) {
    var regex=new RegExp("select_"+selectType+"_");
    var result= $('input').filter(function() {return this.id.match(regex);});
    return result;
  }
  const checkRowsAndColumnsSelectAll = () => {
        // all select row check boxes
        var rows = getSelectCheckboxes('row');
        // all select columnn check boxes
        var cols = getSelectCheckboxes('col');
        // console.log("rows: "+rows.length+", cols:"+cols.length+" total: "+all.length);
        // now check the completeness of the rows
        for (let row = 0; row < rows.length; row++) {
          var rowall=$('.row_'+row);
  		
          var rowchecked=rowall.filter(':checked');
          if (rowall.length == rowchecked.length) {
            $("#select_row_"+row).prop("checked", true);
          } else {  
            $("#select_row_"+row).prop("checked", false);
          }
       }
  	    // now check the completeness of the columns
        for (let colmn = 0; colmn < cols.length; colmn++) {
          var colall=$('.col_'+colmn);
  		
          var colchecked=colall.filter(':checked');
          if (colall.length == colchecked.length) {
            $("#select_col_"+colmn).prop("checked", true);
          } else {  
            $("#select_col_"+colmn).prop("checked", false);
          }
       }
  };
  const checkSelectAll = () => {
        // get the list of grid checkbox elements
        // all checkboxes
        var all = $('.checkBoxClass');
        // get the total number of checkboxes in the grid
        var allLen=all.length; // 4
        // get the number of checkboxes in the checked state
        var filterLen=all.filter(':checked').length;
        // console.log(allLen+"-"+filterLen);
        // if all checkboxes are in the checked state  
        // set the state of the selectAll checkbox to checked to be able
        // to deselect all at once, otherwise set it to unchecked to be able to select all at once
        if (allLen == filterLen) {
          $("#selectall").prop("checked", true);
        } else {
          $("#selectall").prop("checked", false);
        }
  };
  $(document).ready(function () {
      // handle click event for Select all check box
      $("#selectall").click(function () {
         // set the checked property of all grid elements to be the same as
         // the state of the SelectAll check box
         var state=$("#selectall").prop('checked');
         $(".checkBoxClass").prop('checked', state);
         getSelectCheckboxes('row').prop('checked', state);
         getSelectCheckboxes('col').prop('checked', state);
      });
  
      // handle clicks within the grid
      $(".checkBoxClass").on( "click", function() {
  		checkSelectAll();
  		checkRowsAndColumnsSelectAll();
  	
  	 
      });
       
      $('input')
        .filter(function() {
          return this.id.match(/select_row_|select_col_/);
      }).on( "click", function() {
        var matchRowColArr=getRegexMatches(/select_(row|col)_([0-9]+)/,this.id);
        var matchRowCol=matchRowColArr[0];
        // console.log(matchRowCol);
        if (matchRowCol.length==2) {
          var selectType=matchRowCol[0];  // e.g. row
          var selectIndex=matchRowCol[1]; // e.g. 2
          // console.log(this.id+" clicked to select "+selectType+" "+selectIndex);
          // e.g. .row_2
          $("."+selectType+"_"+selectIndex)
           .prop('checked', $("#select_"+selectType+"_"+selectIndex).prop('checked'));
  		 
  		 
  		checkSelectAll();
  		checkRowsAndColumnsSelectAll();
       }
      });
    });
  
   
     
   
</script>