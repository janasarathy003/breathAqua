<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\models\User;
use common\models\SwimServicecenterlogin;
use backend\models\ForgetPasswordRequestLog;
use api\modules\v1\models\UserLoginApi;
use common\models\UserLogin; 
use yii\db\Query;
use yii\helpers\ArrayHelper;

//use backend\models\UserLogin;
/**
 * Site controller
 */
class UserchangelogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

     public function beforeAction($action) {  
      $this->enableCsrfValidation = false;
      return parent::beforeAction($action);
  }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }# Message PAge 

    public function actionAfterLogin($value=""){ 
        return $this->render('message',['register'=>'merchant']);
    }
     public function getRandomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $randomString; 
    }

public function mailtemplate($input=array()){
       $html = '
<!doctype html>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   
</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
  <center style="width: 100%; background-color: #f1f1f1; ">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
      &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 600px; margin: 0 auto;" class="ema il-container">
      <!-- BEGIN BODY -->
  <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
    <tr>
      <td valign="top"   style="padding: 1em 2.5em 0 2.5em;background: #ffffff;">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="">
          <tr>
            <td   style="text-align: left;">
              <h1 style="margin: 0;">
                <a href="#" target="_blank" >
                  <img src="https://dev.afynder.com/afynder/admin/images/afynderLogo.png" width="100">
                </a>
              </h1>
            </td>
            <td style="text-align: right;">
                  <ul class="social" style="display:none;">
                    <li><a href="#"><img src="https://dev.afynder.com/afynder/admin/images/004-twitter-logo.png" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                    <li><a href="#"><img src="https://dev.afynder.com/afynder/admin/images/005-facebook.png" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                    <li><a href="#"><img src="https://dev.afynder.com/afynder/admin/images/006-instagram-logo.png" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                  </ul>
                </td>
          </tr>
        </table>
      </td>
    </tr>
     <tr>
          <td valign="middle" style="background-image: url(https://dev.afynder.com/afynder/admin/images/shoppingbag-header.jpg); background-size: cover; height: 260px;"></td>'; 
        $family = 'system-ui';
        #upcoming
         if ($input['type']=="register") { 
        $html .='<tr>
          <td valign="middle" style="padding: 2em 0 4em 0;position: relative;z-index: 0;background-color: #ffffff;">
            <table>
              <tr>
                <td>
                ';
                $html .='
                  <div class="text" style="  text-align: center; font-family: '.$family.', sans-serif;">';
                   $html .='
                    <h2 style="  font-size: 30px;margin-bottom: 0;font-weight: 400;line-height: 1.6;margin-top: 0;">Welcome '.$input['Merchant']['name'].'</h2>
                    <h3 style="padding: 0 1.82em;color: #000;font-size: 17px;font-weight: 300;line-height: 1.5 !important;margin-top:0px;">Thank you for registering as a merchant of aFynder. Your merchant account is active now.</h3>
                    <h3 style="color: #000;font-size: 17px;font-weight: 300;line-height: 1.5 !important;">To login to your account use the following credentials</h3>
                    <h3 style="color:#000;font-size: 17px;font-weight: 300;line-height: 1.5 !important;">Login ID: '.$input['Merchant']['mail'].' / '.$input['Merchant']['contact'].'<br>
                      Password: ********<br><i style="font-size: 16px;">Use the password given during registration</i></h3>
                     
                     
                    <p><a href="https://dev.afynder.com/merchant/home" target="_blank"   style="border-radius: 5px; background: #30e3ca;color: #ffffff; padding: 10px 15px; display: inline-block;text-decoration: none;">Login Now</a></p>
                    <h4 style="font-size: 15px;font-weight: 400;line-height: 1.8 !important;padding: 0 2em;">*You will receive the payment receipt in a separate mail after payment confirmation!</h4>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr> ';
      }
        #expired 
        
        $html .='
       </table>
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        
       <tr>
          <td class="bg_light" style="background: #fafafa; text-align: left; padding-left: 10px; line-height: 1.4; font-size: 13px;">
            <p style="color: rgba(0,0,0,.4);">If you did not intend to register an account, someone may have registered with your information by mistake. Please contact Customer Support using the contact details found at: <a href="https://afynder.com/contactus" target="_new" style="color: rgba(0,0,0,.8);">https://afynder.com/contactus</a></p>
            <p style="color: rgba(0,0,0,.4);">If you would like to view further information on our terms, policies and conditions, you can visit the following location:</p>
            <p style="color: rgba(0,0,0,.4);">Terms of Service and User Agreement:</p>
            <p style="color: rgba(0,0,0,.4);"><a href="https://afynder.com/termsandconditions" target="_new" style="color: rgba(0,0,0,.8);">https://afynder.com/termsandconditions</a></p>
            <p style="color: rgba(0,0,0,.4);">© 2020 aFynder</p>
             
          </td>
        </tr>
      </table>

    </div></center></body></html>';
      return $html;
     // echo $html; die;
    }
    
    public function actionMessage($message=""){
      $this->layout="usermain"; 
         return $this->render('message',['register'=>$message]);
    }
      public function actionForgotpassword($id=""){
        $this->layout="usermain"; 
        if ($id!="") {
            $id = base64_decode($id); 
        }
        if (Yii::$app->request->post()) {
            $usertype = "";
            $requestInput=array();
            $requestInput["userName"] = $_POST['email'];
            $requestInput["apiMethod"] = "forgotPassword";
            $user = new UserLoginApi();
            $Resp = $user->ForgetPassword($requestInput);

            if (array_key_exists('status', $Resp)) {
                if ($Resp['status']=="success") {
                    return $this->render('message',['register'=>"Forget"]); 
                } else{
                    return $this->render('forgotpassword',['message'=>"Email Id or Mobile Number Mismatched"]);
                }
            }else{
                return $this->render('forgotpassword',['message'=>"Email Id or Mobile Number Mismatched"]);
            }
        }else{ 
            return $this->render('forgotpassword',['id'=>$id]);
        }
    }

      # change password
  public function actionChangepassword($id="",$data="")
    {
         $this->layout="usermain"; 
          $id = base64_decode($id); //echo $id; die;
          $id = "janarthanan.istrides@gmail.com";
          $data = base64_decode($data); //echo $data; die;
          if (!empty($data)) {
            $reqtable = ForgetPasswordRequestLog::find()->where(['autoid'=>$data])->andWhere(['status'=>'requested'])->andWhere(['requestType'=>'merchant'])->one();
            if (empty($reqtable)) {
              $this->redirect(['message','register'=>'link-error']);
            }
          }
        if (Yii::$app->request->post()) {  
            // echo "<pre>";print_r($_POST);die;
            $reqFor = '';
            if(array_key_exists('autoid', $_POST)){
                $reqFor = $_POST['autoid'];
            } 
              $model = UserLogin::find()->where(['emailId'=>$_POST['emailid']])->andWhere(['is_active'=>"1"])->one();
              
                if (!empty($model)) {                   
                    if($_POST['password']!=""){   
                        $model->auth_key  = Yii::$app->security->generateRandomString();
                        $model->password  = Yii::$app->security->generatePasswordHash($_POST['password']);
                        $model->ip_address = $_SERVER['REMOTE_ADDR'];
                        if ($model->save()) {
                            $reqtable = ForgetPasswordRequestLog::find()->where(['autoid'=>$reqFor])->andWhere(['status'=>'requested'])->andWhere(['requestType'=>'merchant'])->one();

                          if (!empty($reqtable)) {
                              $reqtable->status = "completed";
                              if($reqtable->save()){
                                $cantable = ForgetPasswordRequestLog::find()->where(['referenceId'=>$model->id])->andWhere(['status'=>'requested'])->andWhere(['requestType'=>'admin'])->all();
                                foreach ($cantable as $key => $value) {
                                   $value->status = "cancelled";
                                   $value->save();
                                }
                              }
                          }
                            $this->redirect(['message','register'=>'merchant-password-update']);
                        }else{
                            $this->redirect(['message','register'=>'password-error']);
                        }
                    }else{
                      //echo "asdas"; die;
                    } 
                }

        

      }else{   
        return $this->render('changepassword',['mailid'=>$id]);
      }
     
    }
  public function actionThanks($thanks=""){
      $this->layout="usermain"; 
      return $this->render('thanks',['register'=>$thanks]);

    }
}
