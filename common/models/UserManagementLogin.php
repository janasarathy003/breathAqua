<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\Session;
use backend\models\StaffTeamMaster;
use backend\models\DepartmentMaster; 
use backend\models\BranchMaster;
use backend\models\RandomGeneration;
use common\models\UserManagementLogin;
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
class UserManagementLogin extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public $servicecentername;
    public $rememberMe = true;
    public $auth_key;


    public static function tableName()
    {
        return 'user_management';
    }

 
    /**
     * @inheritdoc
     */
      public function rules()
    {
        return [
            ['activeStatus', 'default', 'value' => self::STATUS_ACTIVE],
            ['activeStatus', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
 
	/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['userId' => $id, 'activeStatus' => self::STATUS_ACTIVE]);
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
            'activeStatus' => self::STATUS_ACTIVE,
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

    public function login($mail=array(),$type="")
    {   
        $session = Yii::$app->session;
        unset($session['user_id']);
        unset($session['user_name']); //echo "<pre>"; print_r($mail); die;
        $session->destroy();
        if ($type=="gmail") {
                $username = $mail['email'];  
            $user_data = UserManagementLogin::find()->where(['mailId'=>$username])->andWhere(['activeStatus'=>'A'])->one();
            if (empty($user_data)) {
                $user_data = new UserManagementLogin();
                $user_data->firstName = $mail['given_name'];  
                $user_data->lastName =  $mail['family_name'];  
                $user_data->mailId =  $mail['email'];   

                $newCode= "";
            $cy = RandomGeneration::find()->where(['key_id'=>'shopee'])->one();
            if($cy){
                $rt = $cy->random_number;
                $nmStr = substr($user_data->firstName, 0, 4);
                $cy->random_number = $cy->random_number+1;
                $cy->save();
                $reee = sprintf('%03u', $rt);
                $newCode = 'SHOPPE-'.$nmStr.'-'.$reee;
            }
            $user_data->userCode = $newCode;


            $n=10;
            $referanceNumber = $this->getRandomString($n);
            $user_data->referenceNumber = 'SHP'.$referanceNumber;

            $n1=5;
            $referanceNumber1 = $this->getRandomString($n1);
            $user_data->RedeemCode = 'SHP-RED-'.$referanceNumber1;
            $user_data->activeStatus="A";
            $user_data -> authKey = Yii::$app->security->generateRandomString();
            $user_data->save();
            }else if(!empty($user_data)){
                $haspassword=$user_data->password;
                $login_id=$user_data->userId;  
                    $session['user_id']  = $user_data->userId; 
                    $session['userCode']  = $user_data->userCode;
                    $session['user_name']  = $user_data->contactNumber;  
                    $session['Userfullname']  = $user_data->firstName.' '.$user_data->lastName;  

                        $session['userProfile'] = "";
                        if ($user_data->profileImage!="" && $user_data->profileImage!=NULL) { 
                            $session['userProfile'] = url::base(true)."/uploads/profileImage/shopee/".$user_data->profileImage; 
                        } 

                    return Yii::$app->user->login($user_data, false ? 3600 * 24 * 30 : 0);
                     
                }else{
                    return FALSE;
                }
        }else if ($type=="facebook") {
               $username = $mail['email'];  
            $user_data = UserManagementLogin::find()->where(['mailId'=>$username])->andWhere(['activeStatus'=>'A'])->one();
           // echo "<pre>"; print_r($user_data); die;
            if (empty($user_data)) {
                $user_data = new UserManagementLogin();
                if (array_key_exists('name', $mail)) {
                    $name = explode(' ', $mail['name']);
                    if(array_key_exists(1, $name)){
                        $user_data->firstName = $name[0];
                    }
                    if(array_key_exists(1, $name)){
                        $user_data->lastName =  $name[1];
                    }   
                }  
                        $user_data->mailId =  $mail['email'];   

                $newCode= "";
            $cy = RandomGeneration::find()->where(['key_id'=>'shopee'])->one();
            if($cy){
                $rt = $cy->random_number;
                $nmStr = substr($user_data->firstName, 0, 4);
                $cy->random_number = $cy->random_number+1;
                $cy->save();
                $reee = sprintf('%03u', $rt);
                $newCode = 'SHOPPE-'.$nmStr.'-'.$reee;
            }
            $user_data->userCode = $newCode;


            $n=10;
            $referanceNumber = $this->getRandomString($n);
            $user_data->referenceNumber = 'SHP'.$referanceNumber;

            $n1=5;
            $referanceNumber1 = $this->getRandomString($n1);
            $user_data->RedeemCode = 'SHP-RED-'.$referanceNumber1;
            $user_data->activeStatus="A";
            $user_data -> authKey = Yii::$app->security->generateRandomString();
            if(!$user_data->save()){
                echo "<pre>"; print_r($user_data->getErrors()); die;
            }
            }else if(!empty($user_data)){
                $haspassword=$user_data->password;
                $login_id=$user_data->userId;  
                    $session['user_id']  = $user_data->userId; 
                    $session['userCode']  = $user_data->userCode;
                    $session['user_name']  = $user_data->contactNumber;  
                    $session['Userfullname']  = $user_data->firstName.' '.$user_data->lastName;
                        $session['userProfile'] = "";
                        if ($user_data->profileImage!="" && $user_data->profileImage!=NULL) { 
                            $session['userProfile'] = url::base(true)."/uploads/profileImage/shopee/".$user_data->profileImage; 
                        } 

                    return Yii::$app->user->login($user_data, false ? 3600 * 24 * 30 : 0);
                     
                }else{
                    return FALSE;
                }
        } else{ 

            // echo "<pre>"; print_r($_REQUEST); die;
            $username = $password = '';
            if(array_key_exists('username', $_REQUEST)){
                $username = $_REQUEST['username'];
            }else if(array_key_exists('mail', $_REQUEST)){
                $username = $_REQUEST['mail'];
            }
            if(array_key_exists('password', $_REQUEST)){
                $password = $_REQUEST['password'];
            }
		
        if ($username!='' && $password!='') { 
            $user_data = UserManagementLogin::find()->where(['OR',['contactNumber' => $username],['mailId' => $username]])->andWhere(['activeStatus'=>'A'])->one();
            if(!empty($user_data)){
                $haspassword=$user_data->password;
                $login_id=$user_data->userId;
				if(Yii::$app->security->validatePassword($password,$haspassword)){
                // echo "string";die;
                    /*$user_data_details = StaffTeamMaster::find()
                        ->where(['staff_id' => $login_id])
                        ->andWhere(['active_status'=>'1'])
                        ->one();
                    if(!empty($user_data_details)){

                    }*/
                    $session['user_id']  = $user_data->userId; 
                    $session['userCode']  = $user_data->userCode;
                    $session['Userfullname']  = $user_data->firstName.' '.$user_data->lastName;
                    if ($user_data->firstName!="" || $user_data->lastName!="") {
                         $session['user_name']  = $user_data->firstName.' '.$user_data->lastName;    
                    }else{
                        $session['user_name']  = $user_data->contactNumber;                         
                    }
  
                        $session['userProfile'] = "";
                        if ($user_data->profileImage!="" && $user_data->profileImage!=NULL) { 
                            $session['userProfile'] = url::base(true)."/uploads/profileImage/shopee/".$user_data->profileImage; 
                        }
                        if(array_key_exists('remember', $_REQUEST) && ($_REQUEST["remember"]=='1' || $_REQUEST["remember"]=='on'))
                            {
                            $hour = time() + 3600 * 24 * 30;
                                setcookie('username', $username, $hour);
                                setcookie('password', $password, $hour);
                            }
                        
                        /*if($this->rememberMe == 1){ 
                            setcookie (\Yii::getAlias('@site_title')."username", $this->username, time()+3600*24*4);
                            setcookie (\Yii::getAlias('@site_title')."password", $this->password, time()+3600*24*4);
                        }else{
                            setcookie (\Yii::getAlias('@site_title')."username", '');
                            setcookie (\Yii::getAlias('@site_title')."password", '');
                        }*/
                        return Yii::$app->user->login($user_data, $this->rememberMe ? 3600*24*30 : 0);

                   // return Yii::$app->user->login($user_data, false ? 3600 * 24 * 30 : 0);
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
        }/*else {
            $session = Yii::$app->session;
            unset($session['user_id']);
            unset($session['user_name']);
            $session->destroy();        
            return false;
        }*/
    }
  
    public function getService()
    {
        return $this->hasOne(SwimServiceCentre::className(), ['center_autoid' => 'servicecenter_id']);
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
	
}
