<?php

namespace backend\models;

use Yii;

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
class UserLogin extends \yii\db\ActiveRecord
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
            [['name','contactNumber','roleId','username','emailId'], 'required'],
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

    public function smsfunction($phone, $sms_message="",$allowToSend="") {
        //return true;
        if($phone!="" && $sms_message!="" && $allowToSend =="yes"){
            $sms_message = str_replace("&", " and " , $sms_message);
            // $sms_message = str_replace("'", " " , $sms_message);
            $sms_message = str_replace("`", " " , $sms_message);
            //$sms_message = str_replace("?", " " , $sms_message);
            $sms_message = urlencode($sms_message);
            $phone  = "91".substr($phone,(strlen($phone)-10),strlen($phone));
            // $phone='9487754437'; 
            // $phone='6380372621';
            // $number='6380';
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
            $model = new SmsLog();
            $model->message = $sms_message;
            $model->number = $phone;
            $model->updatedipaddress = $_SERVER['REMOTE_ADDR'];
            $model->createddate = date('Y-m-d H:i:s');
            $model->responselog = $response;
            $model->save();
            if ($err) {
                $response=false;
            } else {
              $response=true;
            }
        }
        return  $response;
    }
}
