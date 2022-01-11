<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\Session;
use backend\models\StaffTeamMaster;
use backend\models\DepartmentMaster;

use backend\models\BranchMaster;
use backend\models\FranchiseType;
use backend\models\FranchiseMaster;
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
        
        if ($username!='' && $password!='') { 
            $user_data = UserLogin::find()->where(['username' => $username])->andWhere(['is_active'=>'1'])->one();

         
           
			if(!empty($user_data)){ 
			 $haspassword=$user_data->password;
             $login_id=$user_data->login_id;
				 
			if(Yii::$app->security->validatePassword($password,$haspassword)){

             $user_data_details = StaffTeamMaster::find()
             ->where(['staff_id' => $login_id])
             ->andWhere(['active_status'=>'1'])
             ->one();



             if(!empty($user_data_details))
             {
                 if($user_data_details->master_type == 'B')
                 {
                        $user_data_details2 = BranchMaster::find()
                        ->where(['branch_id' => $user_data_details->branch_id])
                        ->andWhere(['active_status'=>'1'])
                        ->one();
                 }
                 else if($user_data_details->master_type == 'F')
                 {
                         $user_data_details2 = FranchiseMaster::find()
                        ->where(['id' => $user_data_details->franchise_id])
                        ->andWhere(['active_status'=>'1'])
                        ->one();
                 }

                      $user_data_details3 = DepartmentMaster::find()
                         ->where(['dept_id' => $user_data_details->process_type])
                         ->andWhere(['active_status'=>'1'])
                         ->one();

                    /*Prathap Create Time:11:34 Franchise Role type Ex:admin,Lead*/
                    $franchisetype=array();
                    if($user_data_details->master_type == 'F'){
                       
                       if($user_data_details2->id!=""){
                        $franchisetype = FranchiseType::find()
                         ->select('functional_rights')
                         ->where(['franchise_master_id' => $user_data_details2->id])
                         ->andWhere(['common_status'=>'F'])
                         ->asArray()
                         ->all();
                       }
                      }

                      $franchisetypejson=json_encode($franchisetype);
                      $session['master_type']  = $user_data_details->master_type;  //Find Out Franchise or Branch
                      $session['dept_id']  = $user_data_details->process_type;
                      // Created By Prathap
                      $session['franchisetypejson']  = $franchisetypejson;
                      $session['branch_id']  = ($user_data_details->master_type == 'B') ?  $user_data_details2->branch_id : $user_data_details2->id ;  
                      $session['branch_code']  = ($user_data_details->master_type == 'B') ? $user_data_details2->branch_code : '';  
                      $session['branch_name']  = ($user_data_details->master_type == 'B') ? $user_data_details2->branch_name : $user_data_details2->company_name;   
                      $session['design_id']  = $user_data_details->role_type;  
                      $session['staff_name']  = $user_data_details->staff_name; 
                      $session['staff_id']  = $user_data_details->staff_id; 
             }

             
             
             
            

                if(!empty($user_data_details3))
                {
                    if($user_data_details3->dept_id=="1")
                    {
                        $session['logcode'] = "SE";
                    }
                    else
                    {
                        $session['logcode'] = "KA";
                    }
                }

                
                
            	$session['user_id']  = $user_data->id;
                $session['user_type']  = "NA";
                $session['user_logintype']  = $user_data->login_id;
           		$session['user_name']  = $user_data->username;	
                

                

                
				$session['login_id']  = $user_data->login_id;  
                  
                
				 		 		         		
            	return Yii::$app->user->login($user_data, false ? 3600 * 24 * 30 : 0);            	
			}else{  
				return FALSE;
			}
			}else{
				return FALSE;
			}
			
        } else {    
        $session = Yii::$app->session;
        unset($session['user_id']);
        unset($session['user_name']);
        $session->destroy();    	
            return false;
        }
    }
  /*  public function afterFind() {
        
         $this->servicecentername = $this->service->service_center_name; 
         
        parent::afterFind();
    }
*/

    public function getService()
    {
        return $this->hasOne(SwimServiceCentre::className(), ['center_autoid' => 'servicecenter_id']);
    }
	/* protected function getUser($user_data)
    {
    	      if ($user_data != "") {
            $this->_user = User::findByUsername($this->username);
					print_r( $this->_user);die;
        }

        return $user_data;
    }*/
}
