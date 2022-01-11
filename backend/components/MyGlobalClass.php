<?php 
namespace backend\components;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\Site;
use yii\helpers\ArrayHelper;
use backend\models\AppContentManagement;



class MyGlobalClass extends \yii\base\Component{
    public function init() {
    	$session=Yii::$app->session;
			$request = Yii::$app->request;

      $year = date('Y');
      $appFotter = $appName = $appDevBy = "";

      $appContentAll = AppContentManagement::find()->asArray()->all();
      if(!empty($appContentAll)){
        $appContentAllAr = ArrayHelper::map($appContentAll,'contentKey','contentValue');
        if(!empty($appContentAllAr)){
          if(array_key_exists('appName', $appContentAllAr)){
            $appName = $appContentAllAr['appName'];
          }
          if(array_key_exists('developedBy', $appContentAllAr)){
            $appDevBy = $appContentAllAr['developedBy'];
          }
          if(array_key_exists('appFotter', $appContentAllAr)){
            $appFotter = $appContentAllAr['appFotter'];
          }
        }
      }
				
		  $s_G=$_SERVER['QUERY_STRING'];
			$s_G=trim($s_G);
      $get_array=explode('/', $_SERVER['REQUEST_URI']);
      $get_uri=end($get_array);

      // if( $get_uri!="" && $get_uri != 'after-login' && $get_uri != 'home' && $get_uri != 'merchant-register' && $get_uri != 'index' &&  $get_uri != 'logout'  && $session['user_id'] == ''){
      if( $get_uri!="" && $get_uri != 'changepassword' && $get_uri != 'forgotpassword?id=bWVyY2hhbnQ=' && $get_uri != 'thanks' && $get_uri != 'index.php' && $get_uri != 'after-login' && $get_uri != 'home' && $get_uri != 'merchant-register' && $get_uri != 'index' &&  $get_uri != 'logout'  && $session['user_id'] == ''){
        $session->destroy();
				echo '<center><div style="border:#999999 solid 2px;;width:25%;">';
				echo "</br>";
				echo '<a>'
          . Html::beginForm(['/site/logout'], 'post')
          . Html::submitButton(
            'Go To Login Page <i class="fa fa-fw fa-sign-out"></i> ',
            ['class' => 'button']
          )
          . Html::endForm()
          . '</a>';
					  
					echo "<span style='font-size:16px;font-weight:bold;'>You're being timed out due to inactivity.<br>Otherwise,You will logged off automatically.</span>";
          echo "<br>";
          echo "<br>";
          echo '<p class="latofont" style="font-size:12px;">© '.$year.' '.$appName.'. '.$appFotter.'</p>';
          echo '</div><center>';
          echo '<style>
          .button {
            border-radius: 4px;
            border: none;
            color: #FFFFFF;
            text-align: center;
            font-size: 18px;
            padding: 6px;
            width: 200px;
            transition: all 0.5s;
            font-family:"Lato", sans-serif!important;
            cursor: pointer;
            margin: 5px;
            background: linear-gradient(to bottom, #283E51, #4B79A1);
          }

          .button span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
          }

          .button span:after {
            content: "\00bb";
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
          }

          .button:hover span {
            padding-right: 25px;
          }

          .button:hover span:after {
            opacity: 1;
            right: 0;
          }
          span,.latofont{

          	font-family:"Lato", sans-serif!important;
          }
          </style>';
                   
			die;
			}else if( $get_uri == 'logout'){
				$session->destroy();
        
       Yii::$app->user->logout();

        $session->destroy();

			}
      else
      {

      }

        parent::init();
    }
}

