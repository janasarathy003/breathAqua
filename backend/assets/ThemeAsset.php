<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ThemeAsset extends AssetBundle
{
	   public function init() {
        $this->jsOptions['position'] = View::POS_END;
        parent::init();
    }
	
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
      
         
       'plugins/plugins/bootstrap-4.4.1-dist/css/bootstrap.min.css',
        'plugins/css/style.css',
        'plugins/css/admin-custom.css',
        
		    'plugins/plugins/toggle-sidebar/sidemenu.css',
		    'plugins/plugins/perfect-scrollbar/perfect-scrollbar.css',
		    'plugins/plugins/fileuploads/css/dropify.css',
        'plugins/css/icons.css',
        'plugins/color-skins/color1.css',
		'plugins/plugins/jquery-ui/jquery-ui.css',
    'plugins/css/customButton.css',
        'plugins/plugins/jqvmap/jqvmap.min.css',
        'plugins/plugins/morris/morris.css',
        'plugins/css/site.css',
        'plugins/css/richtext.css',
        'plugins/css/jquery.ui.timepicker.css',
        'plugins/plugins/daterange-picker/daterangepicker.css',
		'plugins/css/style.jrac.css',
		'plugins/css/afynder-custom.css',
		'font/ubuntu/ubuntu.css',
        
        
    ];
	
	
    public $js = [   		
    // 'plugins/js/vendors/jquery-3.2.1.min.js', 
     'plugins/plugins/bootstrap-4.4.1-dist/js/popper.min.js',
      'plugins/plugins/bootstrap-4.4.1-dist/js/bootstrap.min.js',
      'plugins/js/vendors/jquery.sparkline.min.js',
      'plugins/js/vendors/selectize.min.js',
      'plugins/js/vendors/jquery.tablesorter.min.js',
      'plugins/js/vendors/circle-progress.min.js',
      'plugins/plugins/rating/jquery.rating-stars.js',
	     'plugins/plugins/toggle-sidebar/sidemenu.js',
	     'plugins/plugins/counters/counterup.min.js',
       'plugins/plugins/counters/counterup.min.js',
       'plugins/js/jquery.richtext.js',
       'plugins/js/jquery.richtext.min.js',
      'plugins/plugins/fileuploads/js/dropify.js',
      'plugins/plugins/counters/waypoints.min.js',
      'plugins/plugins/toggle-sidebar/sidemenu.js',
	 // 'plugins/plugins/chart/utils.js',
    
	//  'plugins/plugins/chart/Chart.bundle.js',
      
	  
	  'plugins/plugins/perfect-scrollbar/perfect-scrollbar.js',
      'plugins/plugins/perfect-scrollbar/p-scroll.js',
	  
      'plugins/plugins/input-mask/jquery.mask.min.js',
      'plugins/plugins/date-picker/spectrum.js',
      'plugins/plugins/date-picker/jquery-ui.js',
      'plugins/plugins/date-picker/jquery-ui.js',
	  
	      
      'plugins/plugins/input-mask/jquery.maskedinput.js',
	 
	     'plugins/js/formelements.js',
	    'plugins/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js',
		'plugins/plugins/datatable/jquery.dataTables.min.js',
      'plugins/plugins/datatable/dataTables.bootstrap4.min.js',      
      'plugins/js/datatable.js',
      'plugins/plugins/select2/select2.full.min.js',
      'plugins/js/select2.js',
      'plugins/plugins/time-picker/jquery.timepicker.js',
	  'plugins/plugins/time-picker/toggles.min.js',
	  
      'plugins/plugins/jqvmap/jquery.vmap.js',
      'plugins/plugins/jqvmap/maps/jquery.vmap.world.js',
      'plugins/plugins/jqvmap/jquery.vmap.sampledata.js',
      'plugins/plugins/echarts/echarts.js',
      
    //  'plugins/js/index1.js', 
	    
      'plugins/js/admin-custom.js',
	  
      'plugins/js/afynder-custom.js',
      'plugins/js/jquery.ui.core.min.js',
      'plugins/js/jquery.ui.timepicker.js',
      'plugins/js/moment.min.js',
	  'plugins/plugins/daterange-picker/daterangepicker.js',
      'plugins/js/jquery.jrac.js', 
      'plugins/js/formeditor.js', 
      // 'plugins/js/jquery.backstretch.js', 
      'sortable/sortable.js',
    ];
	
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
