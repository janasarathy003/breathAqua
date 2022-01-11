<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use api\modules\v1\models\ApiRequestResponseLog;
use api\modules\v1\models\PackageLimitationMappingApi;
use api\modules\v1\models\MerchantMasterApi;
use backend\models\MerchantMaster;
use backend\models\MerchantPackageMaster;
use backend\models\RenewalMailLog;
use backend\models\RandomGeneration;
use backend\models\MerchantPackageSubscribeLog; 
use api\modules\v1\models\MerchantCategoryMasterApi;
use yii\db\Query;
/**
 * Site controller
 */
class MerchantController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
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

     #Curl Image Upload by chellappan on 25-12-2020 
    public function actionCurlupload(){ 
           //echo "<pre>"; print_r($_POST); print_r($_FILES); die;

           $merch = new MerchantMaster();
           $merchupload = $merch->curlupload($_FILES);
           print_r($merchupload);
    }
    # Author : Jana
    # Timestamp : 20-02-2020 12:10 PM
    # Desc : Mobile Api Login Services

    public function actionLogin()
    {
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true); 
        $uniqueCode = "";  
        if(array_key_exists('mobileUniqueCode', $requestInput)){
            $uniqueCode = $requestInput['mobileUniqueCode'];
        }
        $list['status'] = 'error';
        $list['message'] = 'Invalid Apimethod';
        

        $model_log = new ApiRequestResponseLog();        
        $model_log->requestData = $postd;
        $model_log->apiMethod   = "Merchant LOgin";
        $model_log->mobileCode  = $uniqueCode;
        $model_log->createdAt   = date("Y-m-d H:i:s");
        $model_log->save();
        $log_id = $model_log->autoid;

        $newMs = new MerchantMasterApi();
        $list  = $newMs->signin($requestInput);
        // echo "<pre>";print_r($log_id);die;
        if($log_id!=''){
            $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
            $model_log->response= json_encode($list);
            if(!$model_log->save()){
                // echo "<pre>";print_r($model_log->getErrors());die;
            }
        }
        // echo "<prE>";print_r($response);die;
        return json_encode($list);
    }
    # Author : Chellappan
    # Timestamp : 08-01-2021 10:26 PM
    # Desc : Renewal Reminder

    public function actionRenewalReminder($id="")
    {
        $session = Yii::$app->session;
        $Keys = $id; 

        $now = date('Y-m-d H:i:s');
        $start_date = strtotime($now);
        if ($Keys=="upcoming") {
        $end_date = strtotime("+7 day", $start_date);
        }
        if ($Keys=="expired") {
        $end_date = strtotime("-7 day", $start_date);
        }
        if ($Keys=="inactive") {
        $end_date = strtotime("-7 day", $start_date);
        }
        $end_date =  date('Y-m-d H:i:s', $end_date); 

        $subscribelog = new Query;
        $subscribelog -> select('*')-> from('merchant_package_subscribe_log'); 
         if ($Keys=="upcoming") {
        $subscribelog ->where(['between', 'subscribeEndDate', $now, $end_date]);
        }
        if ($Keys=="expired") {
        $subscribelog ->where(['between', 'subscribeEndDate', $end_date, $now]);
        }
        if ($Keys=="inactive") { 
        $subscribelog ->where(['<', 'subscribeEndDate', $end_date]);
        }
        $command = $subscribelog->createCommand();
        $subscribelog = $command->queryAll(); 
        
         
        $merchantId = ArrayHelper::map($subscribelog,"logId",'merchantId');
        $model = MerchantMaster::find()->where(['IN','merchantId',$merchantId])->all(); 
       // echo "<pre>"; print_r($merchantId); die; 
        //$model = $this->findModel($id); 
        if (!empty($model)) { 
            $body="";
        foreach ($model as $key => $value) {  
            $package = MerchantPackageSubscribeLog::find()->where(['merchantId'=>$value->merchantId])->andWhere(['status'=>"pending"])->asArray()->one();
          if (!empty($package)) { 
            $headers = 'From: afynder@gmail.com' . "\r\n" .
                'Reply-To: noreply@afynder.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $to = trim($value->shopMailId); 
            //$to = trim("chellappan.istrides@gmail.com"); 
            $url = base64_encode($to);
            $sub = "Renewal Reminder - Afynder";
           // $body = '<h4>Dear '.$model->ShopName.',</h4>';
              $requestInput=array();
              $requestInput["Merchant"] = $value;
              $requestInput["Package"] = $package;
            if ($Keys=="upcoming") {
              $requestInput["type"] = "upcoming";
            }
            if ($Keys=="expired") {
              $requestInput["type"] = "expired"; 
            }
            if ($Keys=="inactive") {  
             $requestInput["type"] = "inactive"; 
            }
              $html  = $this->upcomingrenewalmail($requestInput); 
              $body = $html; 
             //echo $body; die; 
           
                $mail = mail($to,$sub,$body,$headers); 
            if ($mail==true) {
              $value->MailedOn = date("Y-m-d H:i:s");
              $value->RenewalMail ="yes";
              $value->save(); 
              $renewal = new RenewalMailLog();
              $renewal->MailTo = $to;
              $renewal->merchantId = $value->merchantId;
              $renewal->PackageId = $package['packageId'];
              $renewal->MailKey = $Keys;
              $renewal->CreatedAt = date("Y-m-d H:i:s");
              $renewal->UpdatedIpaddress = $_SERVER['REMOTE_ADDR'];
              $renewal->userid = $session['user_id'];
              if (!$renewal->save()) {
                echo "<pre>"; print_r($renewal->getErrors()); die;  
              }
              //$renewal->save();
              echo "Mail Sent";  
            }else{
              echo "Mail not sent";  
            }
          }else{
              echo "Mail not sent";  
          }
        }
      } die;
    }
    # Author : Chellappan
    # Timestamp : 09-01-2021 10:34 PM
    # Desc : Mail Template for Renewals

     public function upcomingrenewalmail($input=array()){
      $merchant = $input['Merchant'];
      $package = $input['Package'];
         $renn = RandomGeneration::find()->where(['key_id'=>'siteBaseUrl'])->asArray()->one();
                    $siteURl = '';
                    if(!empty($renn)){
                        $siteURl = $renn['random_number'];
                    }
          $rennGen = RandomGeneration::find()->where(['key_id'=>'baseurlMerchant'])->asArray()->one();
        $baseURl = '';
        if(!empty($rennGen)){
            $baseURl = $rennGen['random_number'];
        }
        $now = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime($package['subscribeEndDate']));   
       
        $datetime1 = new \DateTime($now);
        $datetime2 = new \DateTime($start_date);

        $difference = $datetime1->diff($datetime2);

        $days = 'in '.$difference->d.' days';
        if ($now==$start_date) {
          $days ="today";
        }
      $packagemaster = MerchantPackageMaster::find()->where(['packageId'=>$package['packageId']])->asArray()->one();
     
       $html = '
<!doctype html>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
      <link href="'.$siteURl.'admin/css/gmail.css" media="all" rel="stylesheet" type="text/css"/>

</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
  <center style="width: 100%; background-color: #f1f1f1;">
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
                  <img src="'.$siteURl.'admin/images/afynderLogo.png" width="100">
                </a>
              </h1>
            </td>
            <td style="text-align: right;">
                  <ul class="social" style="display:none;">
                    <li><a href="#"><img src="'.$siteURl.'admin/images/004-twitter-logo.png" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                    <li><a href="#"><img src="'.$siteURl.'admin/images/005-facebook.png" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                    <li><a href="#"><img src="'.$siteURl.'admin/images/006-instagram-logo.png" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                  </ul>
                </td>
          </tr>
        </table>
      </td>
    </tr>
     <tr>
          <td valign="middle" style="background-image: url('.$siteURl.'admin/images/shoppingbag-header.jpg); background-size: cover; height: 260px;"></td>'; 
        $family = 'system-ui';
        #upcoming
         if ($input['type']=="upcoming") { 
        $html .='<tr>
          <td valign="middle" style="padding: 2em 0 4em 0;position: relative;z-index: 0;background-color: #ffffff;">
            <table>
              <tr>
                <td>
                  <div class="text" style="padding: 0 2.5em; text-align: center; font-family: '.$family.', sans-serif;">
                    <h2 style="color: #000;font-size: 30px;margin-bottom: 0;font-weight: 400;line-height: 1.6;">Hi, '.$merchant->ShopName.'</h2>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Your subscirption is about to expire <B style="color: red !important">'.$days.'</B></h3>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Please renew immediately to keep your account active. Find your subscription details below,</h3>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Your Package: <b>'.$packagemaster['packageName'].'</b></h3>
                    <h3 style="line-height: 0.1 !important;font-size: 20px;font-weight: 300;">Amount: <b>&#8377; '.$packagemaster['packageAmount'].'</b></h3>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Expired on: <b>17/01/2021</b></h3></span>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">To login into your account click the button below,</h3>
                    <p><a href="'.$baseURl.'home" target="_blank"   style="border-radius: 5px; background: #30e3ca;color: #ffffff; padding: 10px 15px; display: inline-block;text-decoration: none;">Merchant Login</a></p>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr> ';
      }
        #expired 
        if ($input['type']=="expired") {
         
        $html .='<tr>
           <td valign="middle" style="padding: 2em 0 4em 0;position: relative;z-index: 0;background-color: #ffffff;">
            <table>
              <tr>
                <td>
                  <div class="text" style="padding: 0 2.5em; text-align: center;font-family: '.$family.', sans-serif;">
                    <h2 style="color: #000;font-size: 30px;margin-bottom: 0;font-weight: 400;line-height: 1.6;">Hi, '.$merchant->ShopName.'</h2>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Your subscirption has <B style="color: red !important">Expired!</B></h3>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Your merchant profile will become in-active if not renewed  '.$days.'. Please renew immediately to keep your account active. Find your subscription details below,</h3>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Your Package: <b>'.$packagemaster['packageName'].'</b></h3>
                    <h3 style="line-height: 0.1 !important;font-size: 20px;font-weight: 300;">Amount: <b>&#8377; '.$packagemaster['packageAmount'].'</b></h3>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Expired on: <b>'.date("d/m/Y", strtotime($package['subscribeEndDate'])).'</b></h3></span>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">To login into your account click the button below,</h3>
                    <p><a href="'.$baseURl.'home" target="_blank"   style="border-radius: 5px; background: #30e3ca;color: #ffffff; padding: 10px 15px; display: inline-block;text-decoration: none;">Merchant Login</a></p>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>'; 
        }
        # inactive
        if ($input['type']=="inactive") { 
         
        $html .='<tr>
           <td valign="middle" style="padding: 2em 0 4em 0;position: relative;z-index: 0;background-color: #ffffff;">
            <table>
              <tr>
                <td>
                  <div class="text" style="padding: 0 2.5em; text-align: center;font-family: '.$family.', sans-serif;">
                    <h2 style="color: #000;font-size: 30px;margin-bottom: 0;font-weight: 400;line-height: 1.6;">Hi, '.$merchant->ShopName.'</h2>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Your account has been <B style="color: red !important">Deactivated</B> due to non payment of subscription renewal charges</h3>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Please renew immediately to make your account active again. Find your subscription details below,</h3>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Your Package: <b>'.$packagemaster['packageName'].'</b></h3>
                    <h3 style="line-height: 0.1 !important;font-size: 20px;font-weight: 300;">Amount: <b>&#8377; '.$packagemaster['packageAmount'].'</b></h3>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">Expired on: <b>17/01/2021</b></h3></span>
                    <h3 style="font-size: 20px;font-weight: 300;line-height: 1.5 !important;">To login into your account click the button below,</h3>
                    <p><a href="'.$baseURl.'home" target="_blank"   style="border-radius: 5px; background: #30e3ca;color: #ffffff; padding: 10px 15px; display: inline-block;text-decoration: none;">Merchant Login</a></p>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr> ';
      }
        $html .='
      </table>
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        
        <tr>
          <td   style="background: #ffffff;text-align: left; padding-left: 10px; line-height: 1.4; font-size: 14px;">
            <p>If you would like to view further information on our terms, policies and conditions, you can visit the following location:</p>
            <p>Terms of Service and User Agreement:</p>
            <p><a href="https://afynder.com/termsandconditions" target="_new" style="color: rgba(0,0,0,.8);">https://afynder.com/termsandconditions</a></p>
            <p>© 2020 aFynder</p> 
          </td>
        </tr>
      </table>

    </div></center></body></html>';
      return $html;
    }

    # Author : Jana
    # Timestamp : 20-02-2020 12:10 PM
    # Desc : Mobile Api Login Services

    public function actionRazorPay()
    {
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        
        $list['status'] = 'success';
        $list['message'] = 'RazorPay authentications';
        

        $model_log = new ApiRequestResponseLog();  
        $model_log->apiMethod   = "Razor pay";
        $model_log->createdAt   = date("Y-m-d H:i:s");
        $model_log->save();
        $log_id = $model_log->autoid;

        $list['RAZOR_KEY_ID'] = 'rzp_live_BxWc220jSrSdOQ';
        $list['RAZOR_KEY_SECRET'] = '7hpTv7fHSO2lSrwW5hyITucY';
        
        if($log_id!=''){
            $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
            $model_log->response= json_encode($list);
            $model_log->save();
        }
        // echo "<prE>";print_r($response);die;
        return json_encode($list);
    }

    # Author : Jana
    # Timestamp : 20-07-2020 10:18 AM
    # Desc : Sign up Merchant using Mobile Application

    public function actionSignup(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true); 
        $uniqueCode = "";  
        if(array_key_exists('mobileUniqueCode', $requestInput)){
            $uniqueCode = $requestInput['mobileUniqueCode'];
        }
        $list['status'] = 'error';
        $list['message'] = 'Invalid Apimethod';
        

        $model_log = new ApiRequestResponseLog();        
        $model_log->requestData = $postd;
        $model_log->apiMethod   = "Merchant Signup";
        $model_log->mobileCode  = $uniqueCode;
        $model_log->createdAt   = date("Y-m-d H:i:s");
        $model_log->save();
        $log_id = $model_log->autoid;

        $newMs = new MerchantMasterApi();
        $list  = $newMs->signup($requestInput);
        if(!empty($list)){
            if($list['status']=='success'){
                $merId = $list['merchantId'];
                $referenceNumber = $list['referenceNumber'];
                $merchantCode = $list['merchantCode'];

                $neww = new MerchantMaster();
                $ress = $neww->QrCode($merId,$referenceNumber,$merchantCode);

                $oldd = MerchantMaster::findOne($merId);
                if($oldd){
                    $oldd->ReferenceCodeFile = $ress;
                    $oldd->save();
                }
            }
        }
        if($log_id!=''){
            $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
            $model_log->response= json_encode($list);
            $model_log->save();
        }
        // echo "<prE>";print_r($response);die;
        return json_encode($list);
    }

    # Author : Jana
    # Timestamp : 07-10-2020 07:58 PM
    # Desc : Sign up Merchant using Mobile Application

    public function actionOtpRequest(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true); 
        $uniqueCode = "";  
        if(array_key_exists('mobileUniqueCode', $requestInput)){
            $uniqueCode = $requestInput['mobileUniqueCode'];
        }
        $list['status'] = 'error';
        $list['message'] = 'Invalid Apimethod';
        

        $model_log = new ApiRequestResponseLog();        
        $model_log->requestData = $postd;
        $model_log->apiMethod   = "Merchant Otp Request";
        $model_log->mobileCode  = $uniqueCode;
        $model_log->createdAt   = date("Y-m-d H:i:s");
        $model_log->save();
        $log_id = $model_log->autoid;

        // echo "<prE>";print_r($requestInput);die;
        $newMs = new MerchantMasterApi();
        $list  = $newMs->getOtp($requestInput);
        
        if($log_id!=''){
            $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
            $model_log->response= json_encode($list);
            $model_log->save();
        }
        return json_encode($list);
    }

    public function actionPackageList(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true); 
        $uniqueCode = "";   //echo "<pre>"; print_r($postd); die;
        if(array_key_exists('mobileUniqueCode', $requestInput)){
            $uniqueCode = $requestInput['mobileUniqueCode'];
        }
        $list['status'] = 'error';
        $list['message'] = 'Invalid Apimethod';
        

        $model_log = new ApiRequestResponseLog();        
        $model_log->requestData = $postd;
        $model_log->apiMethod   = "Merchant Signup";
        $model_log->mobileCode  = $uniqueCode;
        $model_log->createdAt   = date("Y-m-d H:i:s");
        $model_log->save();
        $log_id = $model_log->autoid;

        $newMs = new PackageLimitationMappingApi();
        $list  = $newMs->package($requestInput);
        
        if($log_id!=''){
            $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
            $model_log->response= json_encode($list);
            $model_log->save();
        }
        // echo "<prE>";print_r($response);die;
        return json_encode($list);
    }

    # Author : Jana
    # Timestamp : 20-07-2020 10:18 AM
    # Desc : Sign up Merchant using Mobile Application

    public function actionCategories(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true); 
        $uniqueCode = "";  
        if(array_key_exists('mobileUniqueCode', $requestInput)){
            $uniqueCode = $requestInput['mobileUniqueCode'];
        }
        $list['status'] = 'error';
        $list['message'] = 'Invalid Apimethod';
        

        $model_log = new ApiRequestResponseLog();        
        $model_log->requestData = $postd;
        $model_log->apiMethod   = "Merchant Signup";
        $model_log->mobileCode  = $uniqueCode;
        $model_log->createdAt   = date("Y-m-d H:i:s");
        $model_log->save();
        $log_id = $model_log->autoid;

        $newMs = new MerchantCategoryMasterApi();
        $list  = $newMs->CategoryList($requestInput);
        
        if($log_id!=''){
            $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
            $model_log->response= json_encode($list);
            $model_log->save();
        }
        // echo "<prE>";print_r($response);die;
        return json_encode($list);
    }


     # Author : Prathap
    # Timestamp : 24-07-2020 09:50 AM
    # Desc : Sign up Shoppe using Mobile Application

    public function actionSignupshoppe(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true); 
        $uniqueCode = "";  
        if(array_key_exists('mobileUniqueCode', $requestInput)){
            $uniqueCode = $requestInput['mobileUniqueCode'];
        }
        $list['status'] = 'error';
        $list['message'] = 'Invalid Apimethod';
        

        $model_log = new ApiRequestResponseLog();        
        $model_log->requestData = $postd;
        $model_log->apiMethod   = "Shoppe Signup";
        $model_log->mobileCode  = $uniqueCode;
        $model_log->createdAt   = date("Y-m-d H:i:s");
        $model_log->save();
        $log_id = $model_log->autoid;

        $newMs = new MerchantMasterApi();
        $list  = $newMs->signupshoppe($requestInput);
        
        if($log_id!=''){
            $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
            $model_log->response= json_encode($list);
            $model_log->save();
        }
        // echo "<prE>";print_r($response);die;
        return json_encode($list);
    }

    # Author : Prathap
    # Timestamp : 24-02-2020 12:10 PM
    # Desc : Mobile Api Login Services

    public function actionLoginshoppe()
    {
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true); 
        $uniqueCode = "";  
        if(array_key_exists('mobileUniqueCode', $requestInput)){
            $uniqueCode = $requestInput['mobileUniqueCode'];
        }
        $list['status'] = 'error';
        $list['message'] = 'Invalid Apimethod';
        

        $model_log = new ApiRequestResponseLog();        
        $model_log->requestData = $postd;
        $model_log->apiMethod   = "Shoppe Login";
        $model_log->mobileCode  = $uniqueCode;
        $model_log->createdAt   = date("Y-m-d H:i:s");
        $model_log->save();
        $log_id = $model_log->autoid;

        $newMs = new MerchantMasterApi();
        $list  = $newMs->signinshoppe($requestInput);
        
        if($log_id!=''){
            $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
            $model_log->response= json_encode($list);
            $model_log->save();
        }
        // echo "<prE>";print_r($response);die;
        return json_encode($list);
    }

    
}


