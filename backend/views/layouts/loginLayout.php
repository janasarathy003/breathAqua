<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url; 
use backend\models\AppContentManagement;

 $appContentAll = AppContentManagement::find()->asArray()->all();
  if(!empty($appContentAll)){
      $appContentAllAr = ArrayHelper::map($appContentAll,'contentKey','contentValue');
      if(!empty($appContentAllAr)){
          if(array_key_exists('appName', $appContentAllAr)){
            $appName = $appContentAllAr['appName'];
          }
          if(array_key_exists('appLogo', $appContentAllAr)){
            $appLogo = $appContentAllAr['appLogo'];
          }
          if(array_key_exists('appLoginBgImg', $appContentAllAr)){
            $bgImg = $appContentAllAr['appLoginBgImg'];
          }
      }
  }
  // echo $appLogo;die;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link href="plugins/plugins/bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet" />
        <!-- Dashboard css -->
        <link href="plugins/css/style.css" rel="stylesheet" />
        <link href="font/ubuntu/ubuntu.css" rel="stylesheet" />
        <style>
            body{
      		    /*  background: #f7f7fb; */	
      	   }   

          .logo {
              width: 200px;
              height: 100px;
              margin-top: 20px;
              margin-left: 35px;
          }

          .image {
            width: 430px;
            height: 430px;
          }

          .border-line {
            border-right: 1px solid #eeeeee;
          }

          .line {
            height: 1px;
            width: 45%;
            background-color: #e0e0e0;
            margin-top: 10px;
          }

          .or {
            width: 10%;
            font-weight: bold;
          }

      .text-sm {
        font-size: 14px !important;
      }

      ::placeholder {
        color: #bdbdbd;
        opacity: 1;
        font-weight: 300;
      }

      :-ms-input-placeholder {
        color: #bdbdbd;
        font-weight: 300;
      }

      ::-ms-input-placeholder {
        color: #bdbdbd;
        font-weight: 300;
      }

      input {
        padding: 10px 12px 10px 12px;
        border: 1px solid lightgrey;
        border-radius: 2px;
        margin-bottom: 5px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        color: #2c3e50;
        font-size: 14px;
        letter-spacing: 1px;
      }

      input:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: 1px solid #304ffe;
        outline-width: 0;
      }

      button:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        outline-width: 0;
      }

      .btn-blue {
        background-color: #1a237e;
        width: 150px;
        color: #fff;
        border-radius: 2px;
      }

      .btn-blue:hover {
        background-color: #000;
        cursor: pointer;
      }

      .login-btn {
        width: 50%;
        text-align: center;
      }
      button.bg-blue {
        background-color: #4049ec !important;
        color: #fff;
      }
      button.bg-blue:hover {
        background-color: #4a53ef !important;
      }
	   
	  
	   a.c-1 {
        color: #f27224;;
      }
	  
	  .limiter {
  width: 100%;
  margin: 0 auto;
}

.container-login100 {
  width: 100%;  
  min-height: 100vh;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px;
   background: #f7f7fb;  
}

.wrap-login100 {
  width: 1170px;
  background: #fff;
  overflow: hidden;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  align-items: stretch;
  flex-direction: row-reverse;

}

/*==================================================================
[ login more ]*/
.login100-more {
  width: 50%;
  background-repeat: no-repeat;
  background-size: contain;
  background-position: center;
  position: relative;
  z-index: 1;
}

.login100-more::before {
  content: "";
  display: block;
  position: absolute;
  z-index: -1;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
 /* background: rgba(0,0,0,0.3);  
  background: #f27f3c9c;  */
  border-right: 1px solid #f7f7fb;
 background: linear-gradient(87deg, rgb(0 20 142 / 98%) , rgb(22 1 107 / 3%) 100%) !important;
}



/*==================================================================
[ Form ]*/

.login100-form {
  width: 50%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  padding:300px 65px 40px 65px;
  
  background-color: transparent;
    background-image: url("<?php echo $appLogo; ?>");
    background-size: 40% 40%;
    background-repeat: no-repeat;
    background-position: top;
}

.login100-form-title {
  font-family: Poppins-Regular;
  font-size: 20px;
  color: #555555;
  line-height: 1.2;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-align: center;
  font-family:ubuntu;

  width: 100%;
  display: block;
}



/*------------------------------------------------------------------
[ Input ]*/

.wrap-input100 {
  width: 100%;
 /* position: relative;
  border: 1px solid #e6e6e6; */
}

.rs1-wrap-input100,
.rs2-wrap-input100 {
  /* width: 50%; */
}

.rs2-wrap-input100 {
  border-left: none;
}

 

/*---------------------------------------------*/

.focus-input100 {
  position: absolute;
  display: block;
  width: calc(100% + 2px);
  height: calc(100% + 2px);
  top: -1px;
  left: -1px;
  pointer-events: none;
  border: 1px solid #00ad5f;

  visibility: hidden;
  opacity: 0;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;

  -webkit-transform: scaleX(1.1) scaleY(1.3);
  -moz-transform: scaleX(1.1) scaleY(1.3);
  -ms-transform: scaleX(1.1) scaleY(1.3);
  -o-transform: scaleX(1.1) scaleY(1.3);
  transform: scaleX(1.1) scaleY(1.3);
}

.input100:focus + .focus-input100 {
  visibility: visible;
  opacity: 1;

  -webkit-transform: scale(1);
  -moz-transform: scale(1);
  -ms-transform: scale(1);
  -o-transform: scale(1);
  transform: scale(1);
}



/*------------------------------------------------------------------
[ Button ]*/
.container-login100-form-btn {
  width: 100%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.login100-form-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
  width: 100%;
  height: 50px;
  border-radius: 3px;
  background: #00ad5f;

  font-family: ubuntu;
  font-size: 12px;
  color: #fff;
  line-height: 1.2;
  text-transform: uppercase;
  letter-spacing: 1px;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.login100-form-btn:hover {
  background: #333333;
}



/*------------------------------------------------------------------
[ Responsive ]*/

@media (max-width: 992px) {
  .login100-form {
    width: 60%;
    padding-left: 30px;
    padding-right: 30px;
  }

  .login100-more {
    width: 40%;
  }
}

@media (max-width: 768px) {
  .login100-form {
    width: 100%;
  }

  .login100-more {
    width: 100%;
  }
}

@media (max-width: 576px) {
  .login100-form {
    padding-left: 15px;
    padding-right: 15px;
    padding-top: 150px;
  }

  .rs1-wrap-input100,
  .rs2-wrap-input100 {
    width: 100%;
  }

  .rs2-wrap-input100 {
    border-left: 1px solid #e6e6e6;
  }
}
	  
.p-b-34 {padding-bottom: 34px;}	  
.m-b-20 {margin-bottom: 20px;}	  
	.p-b-239 {padding-bottom: 239px;}  
	  
	.p-t-27 {padding-top: 27px;}  
    </style>
    <?php $this->
    head() ?>
  </head>
  <body class="hold-transition">
    <?php $this->beginBody() ?>

    <div class="bg">
      <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
      </div>
    </div>

    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
