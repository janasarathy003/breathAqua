<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_login".
 *
 * @property int $id
 * @property string $master_type S=Super Admin,U=User Login
 * @property string $name
 * @property int $contactNumber
 * @property string $emailId
 * @property string $address
 * @property string $profileImage
 * @property int $roleId
 * @property string $role
 * @property int $login_id User Management Autoid
 * @property int $franchise_id
 * @property string $username
 * @property string $staff_name
 * @property string $auth_key
 * @property string $password
 * @property int $role_type Designation
 * @property int $dept_id Departmant
 * @property string $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $ip_address
 * @property string $system_name
 * @property int $user_id
 * @property string $user_role
 */
class UserLoginApi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_login';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['master_type', 'address', 'profileImage', 'auth_key', 'password'], 'string'],
            [['name','contactNumber','roleId','username'], 'required'],
            [['contactNumber', 'roleId', 'login_id', 'franchise_id', 'role_type', 'dept_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'emailId', 'role', 'username', 'staff_name', 'is_active', 'ip_address', 'system_name', 'user_role'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['emailId'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_type' => 'Master Type',
            'name' => 'Name',
            'contactNumber' => 'Contact Number',
            'emailId' => 'Email ID',
            'address' => 'Address',
            'profileImage' => 'Profile Image',
            'roleId' => 'Role',
            'role' => 'Role',
            'login_id' => 'Login ID',
            'franchise_id' => 'Franchise ID',
            'username' => 'Username',
            'staff_name' => 'Staff Name',
            'auth_key' => 'Auth Key',
            'password' => 'Password',
            'role_type' => 'Role Type',
            'dept_id' => 'Dept ID',
            'is_active' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'ip_address' => 'Ip Address',
            'system_name' => 'System Name',
            'user_id' => 'User ID',
            'user_role' => 'User Role',
        ];
    }


    public function ForgetPassword($input = array())
    {
        $requestInput = $input; 
        $uniqueCode = "";  
        if(array_key_exists('mobileUniqueCode', $requestInput)){
            $uniqueCode = $requestInput['mobileUniqueCode'];
        }
        $list['status'] = 'error';
        $list['message'] = 'Invalid Apimethod';
        $field_check=array('apiMethod','userName');

        $is_error = '';
        foreach ($field_check as $one_key) {
            $key_val =isset($requestInput[$one_key]);
            if ($key_val == '') {
                $is_error = 'yes';
                $is_error_note = $one_key;
                break;
            }
        } 
        if ($is_error == "yes") {
            $list['status'] = 'error';
            $list['message'] = $is_error_note . ' is Mandatory.';
        }else{
            $apiMethod = $requestInput['apiMethod'];
            $userName = $requestInput['userName'];
            $list['message'] = 'Invalid API Method';
            if($apiMethod == 'forgotPassword'){
                $list['message'] = 'Username not registered';
                $merchantMs = UserLoginApi::find()->where(['OR',['contactNumber'=>$userName],['username'=>$userName],['emailId'=>$userName]])->andWhere(['is_active'=>'1'])->asArray()->one(); 
                if(!empty($merchantMs)){ 
                    $model = new ForgetPasswordRequestLog();
                    $model->requestType = "admin";
                    $model->referenceId = $merchantMs['id'];
                    $model->mailId = $merchantMs['emailId'];
                    $model->status = "requested";
                    $model->createdAt = date('Y-m-d H:i:s');
                    $model->updatedIpAddress = $_SERVER['REMOTE_ADDR'];
                    $model->save();
                    
                    $headers = 'From: Ytchannel@gmail.com' . "\r\n" .
                                'Reply-To: noreply@ytchannel.com' . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    $to = trim($merchantMs['emailId']);

                    $url = base64_encode($to);
                    $sub = "Forgot Password";
                    $requestInput=array();
                    $requestInput["Url"] = $url;
                    $requestInput["autoid"] = base64_encode($model->autoId);
                    $requestInput["type"] = "ForgetPasswod";
                    $requestInput["usertype"] = base64_encode("admin");
                    $html  = $this->mailtemplate($requestInput); 
                    $body = $html; 

                    $mail = mail($to,$sub,$body,$headers);

                    if ($mail==true) {
                    //  echo $to;  
                    }else{
                     // echo "No";  
                    } // die;
                    $list['status'] = 'success';
                    $list['message'] = 'Password reset link sent to the registered email id.';
                }
            }
        }
        return $list;
    }

    public function mailtemplate($input=array()){   //echo "<pre>"; print_r($input); die;
        $rennGen = RandomGeneration::find()->where(['key_id'=>'baseurlMerchant'])->asArray()->one();
        $baseURl = '';
        if(!empty($rennGen)){
            $baseURl = $rennGen['random_number'];
        }
        $rennGen = RandomGeneration::find()->where(['key_id'=>'baseurlAdmin'])->asArray()->one();
        $AdminURL = '';
        if(!empty($rennGen)){
            $AdminURL = $rennGen['random_number'];
        } 
        $rennGen = RandomGeneration::find()->where(['key_id'=>'siteBaseUrl'])->asArray()->one();
        $siteURL = '';
        if(!empty($rennGen)){
            $siteURL = $rennGen['random_number'];
        }
        $html = '<!doctype html>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
  <center style="width: 100%; background-color: #f1f1f1;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;"> 
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
                  <img src="'.$AdminURL.'images/afynderLogo.png" width="100">
                </a>
              </h1>
            </td>
            <td style="text-align: right;">
                  <ul class="social" style="display:none;">
                    <li><a href="#"><img src="'.$AdminURL.'images/004-twitter-logo.png" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                    <li><a href="#"><img src="'.$AdminURL.'images/005-facebook.png" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                    <li><a href="#"><img src="'.$AdminURL.'images/006-instagram-logo.png" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                  </ul>
                </td>
          </tr>
        </table>
      </td>
    </tr>
     <tr>
          <td valign="middle" style="background-image: url('.$AdminURL.'images/shoppingbag-header.jpg); background-size: cover; height: 260px;"></td>'; 
          $family = 'system-ui';
        if ($input['type']=="ForgetPasswod") {
                $html .='<tr>
          <td valign="middle" style="padding: 2em 0 4em 0;position: relative;z-index: 0;background-color: #ffffff;">
            <table>
              <tr>
                <td>
                  <div class="text" style="padding: 0 2.5em; text-align: center; font-family: '.$family.', sans-serif;">
                  <h1  style="font-size: 30px;font-weight: 600;line-height: 1.5 !important;">Password Reset</h1>
                   <h3 style="font-size: 16px;font-weight: 300;line-height: 1.5 !important;">Seems like you forgot your password for your Merchant account. If this is true, click below to reset your password</h3> 
                   <p><a href="'.$baseURl.'changepassword?id='.$input['Url'].'&data='.$input['autoid'].'" target="_blank"   style="border-radius: 5px; background: #337ab7;color: #ffffff; font-size:20px; padding: 10px 15px; display: inline-block;text-decoration: none;">Reset My Password</a></p>
                   
                   <h3 style="font-size: 16px;font-weight: 300;line-height: 1.5 !important;">If you did not forgot your password you can safely ignore this email.</h3> 
               
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
          <td class="bg_light" style="background: #fafafa; text-align: left; padding-left: 10px; line-height: 1.4; font-size: 14px;">
             
            <p style="color: rgba(0,0,0,.4);">Terms of Service and User Agreement:</p>
            <p style="color: rgba(0,0,0,.4);"><a href="https://afynder.com/termsandconditions" target="_new" style="color: rgba(0,0,0,.8);">https://afynder.com/termsandconditions</a></p>
            <p style="color: rgba(0,0,0,.4);">© 2020 aFynder</p>
             
          </td>
        </tr>
      </table>

    </div></center></body></html>';
      return $html;
    }

}
