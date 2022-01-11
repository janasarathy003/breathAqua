<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\Session;
use yii\web\IdentityInterface;
//use backend\models\UserLogin;
//use backend\models\ExecutiveMaster;
//use backend\models\SwimServicecenterlogin;
/**
 * This is the model class for table "swim_servicecenterlogin".
 *
 * @property integer $id
 * @property string $servicecenter_id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property string $user_type
 * @property string $city
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $rights
 * @property string $status_flag
 * @property string $user_level
 * @property string $mobile_number
 * @property string $designation
 */
class UserLogin extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $servicecentername;
        
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
           // ['status', 'default', 'value' => self::STATUS_ACTIVE],
          //  ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
   /* public function rules()
    {
        return [
            [['servicecenter_id', 'username', 'password_hash'], 'required'],
             [['username'], 'unique'],
            [['dob'], 'safe'],
            [['user_type', 'rights', 'status_flag'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['servicecenter_id'], 'string', 'max' => 50],
            [['username', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'city'], 'string', 'max' => 70],
            [['auth_key'], 'string', 'max' => 32],
            [['user_level', 'mobile_number'], 'string', 'max' => 20],
            [['designation'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }*/
	/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
/**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['swim_servicecenterlogin.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
/**
     * @inheritdoc
     */
    public function getId()
    {	return 1;
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function login()
    {   
        $session = Yii::$app->session;
        unset($session['user_id']);
        unset($session['user_name']);
        $session->destroy();
        $username = $_REQUEST['LoginForm']['username'];
		$password = $_REQUEST['LoginForm']['password'];
        // echo $username.' --- '.$password;die;
        if ($username!='' && $password!='') { 
            $user_data = UserLogin::find()->where(['OR',['username' => $username],['emailId' => $username]])->andWhere(['is_active'=>'1'])->andWhere(['OR',['master_type'=>'S'],['master_type'=>'SD']])->one();
            // echo "<pre>";print_r($user_data);die;
            if(!empty($user_data)){
                $haspassword=$user_data->password;
                $login_id=$user_data->login_id;
                // echo $haspassword;die;
				if(Yii::$app->security->validatePassword($password,$haspassword)){
                // echo "string";die;
                    /*$user_data_details = StaffTeamMaster::find()
                        ->where(['staff_id' => $login_id])
                        ->andWhere(['active_status'=>'1'])
                        ->one();
                    if(!empty($user_data_details)){

                    }*/
                    $session['user_id']  = $user_data->id;
                    $session['user_type']  = $user_data->master_type;
                    $session['user_logintype']  = $user_data->login_id;
                    $session['user_name']  = $user_data->username;	
                    $session['staff_name']  = $user_data->staff_name;  
                    $session['login_id']  = $user_data->login_id;  

                    $session['userId'] = $user_data->id;
                    $session['merchantId'] = $user_data->merchantId;
                    $session['userName'] = $user_data->name;
                    $session['roleId'] = $user_data->roleId;
                    $session['loginUserName'] = $user_data->username;

                    $session['userProfile'] = "";
                    $base = url::base(true);
                    $base = str_replace('/admin', '/backend/web', $base);

                    if ($user_data->profileImage!="" && $user_data->profileImage!=NULL) { 
                        $session['userProfile'] = $base."/uploads/profileImage/user/".$user_data->profileImage; 
                    }
                    
                    return Yii::$app->user->login($user_data, false ? 3600 * 24 * 30 : 0);
                }else{  
                    return FALSE;
                }
            }else{
				return FALSE;
			}
		}else {
            $session = Yii::$app->session;
            unset($session['user_id']);
            unset($session['user_name']);
            $session->destroy();    	
            return false;
        }
    }
  
    public function getService()
    {
        return $this->hasOne(SwimServiceCentre::className(), ['center_autoid' => 'servicecenter_id']);
    }
	public function smsfunction($phone, $sms_message="") {
        //return true;
            
             if($phone!="" && $sms_message!=""){
                  $sms_message = str_replace("&", " and " , $sms_message);
                  $sms_message = str_replace("'", " " , $sms_message);
                  $sms_message = str_replace("`", " " , $sms_message);
                  //$sms_message = str_replace("?", " " , $sms_message);
                  $sms_message = urlencode($sms_message);
                  $phone  = "91".substr($phone,(strlen($phone)-10),strlen($phone));
              //$phone='9487754437'; 
              //$phone='6380372621';
              //$number='6380';
           // $url="http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp?username=e34&password=2342&sendername=23423&mobileno=".$phone."&message=".$sms_message;

            $url="https://api.mylogin.co.in/api/v2/SendSMS?SenderId=FYNDER&Is_Unicode=true&Is_Flash=false&ApiKey=yakcv2Xh%2F5UCgR2FQDShF4zDodTtcOR7%2FB%2B9hs%2BOx48%3D&ClientId=b3afea27-8dd9-44cd-8b54-fde56692f09a&MobileNumbers=".$phone."&Message=".$sms_message;
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
            //echo   $response = "cURL Error #:" . $err;
                $response=false;
            } else {
              $response=true;
            }
          }
      
        return  $response;
    }
}
