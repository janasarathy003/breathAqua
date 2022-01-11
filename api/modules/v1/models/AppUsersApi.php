<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "app_users".
 *
 * @property int $userId
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phoneNumber
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class AppUsersApi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdAt', 'updatedAt'], 'safe'],
            [['email'], 'email'],
            [['name','password'], 'string', 'max' => 255],
            [['phoneNumber'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'phoneNumber' => 'Phone Number',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    public function signup($requestInput = array())
    {
        $list['status'] = 'error';
        $list['message'] = 'Invalid ';
        $field_check=array('apiMethod','password','confirmPassword','name','mailId');
        
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
            $password = $requestInput['password'];
            $confirmPassword = $requestInput['confirmPassword'];
            $name = $requestInput['name'];
            $mailId = $requestInput['mailId'];
            $phoneNumber = "";
            if(array_key_exists('phoneNumber', $requestInput) && $requestInput['phoneNumber']!=""){
                $phoneNumber = $requestInput['phoneNumber'];
            }
            $list['message'] = "Invalid Api Method";
            if($apiMethod=="newUserRegister"){
                $list['message'] = "Password not matched.";
                if($password == $confirmPassword){
                    $phoneAllow = "yes";
                    if($phoneNumber!=""){
                        $phoneAllow = "no";
                        $list['message'] = "Phone number already registered";
                        $allPre = AppUsersApi::find()->where(['phoneNumber'=>$phoneNumber])->andWhere(['status'=>'active'])->asArray()->one();
                        if(empty($allPre)){
                            $phoneAllow = "yes";
                        }
                    }
                    if($phoneAllow=='yes'){
                        $list['message'] = "Mailid already registered";
                        $allPre = AppUsersApi::find()->where(['email'=>$mailId])->andWhere(['status'=>'active'])->asArray()->one();
                        if(empty($allPre)){
                            $newUser = new AppUsersApi();
                            $newUser->name = $name;
                            $newUser->email = $mailId;
                            $newUser->authKey = Yii::$app->security->generateRandomString();
                            $newUser->password = Yii::$app->security->generatePasswordHash($password);
                            $newUser->phoneNumber = $phoneNumber;
                            $newUser->status = 'active';
                            $newUser->createdAt = date('Y-m-d H:i:s');
                            $newUser->updatedAt = date('Y-m-d H:i:s');
                            if($newUser->save()){
                                $list['status'] = "success";
                                $list['message'] = "New user added";
                            }else{
                                echo "<prE>";print_r($newUser->getErrors());die;
                            }
                        }                        
                    }
                }
            }
        }
        return $list;
    }


    public function signin($requestInput = array())
    {
        $list['status'] = 'error';
        $list['message'] = 'Invalid ';
        $field_check=array('apiMethod','userName','password');
        
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
            $password = $requestInput['password'];
            $userName = $requestInput['userName'];
            $list['message'] = "Invalid Api Method";
            if($apiMethod=="userLogin"){
                $list['message'] = "User not found.!";
                $userList = AppUsersApi::find()->where(['OR',['phoneNumber'=>$userName],['email'=>$userName]])->andWhere(['status'=>'active'])->asArray()->one();
                if(!empty($userList)){
                    $dataAr = array();
                    foreach ($userList as $key => $value) {
                        $dataAr[$key] = $value;
                    }
                    $list['status'] = "success";
                    $list['message'] = "User Details";
                    $list['userDetails'] = $dataAr;
                }
            }
        }
        return $list;
    }

    # Favorite video management   

    public function FavVideoManagement($requestInput = array())
    {
        $list['status'] = 'error';
        $list['message'] = 'Invalid ';
        $field_check=array('apiMethod','userId','userType');
        if(array_key_exists('apiMethod', $requestInput)){
            if($requestInput['apiMethod']=='addToFav'){
                $field_check=array('apiMethod','videoId','userId','userType');
            }if($requestInput['apiMethod']=='removeFromFav'){
                $field_check=array('apiMethod','videoId','userId','userType');
            }
        }
        
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
            $userId = $requestInput['userId'];
            $userType = $requestInput['userType'];
            $list['message'] = "login required to access this feature.!";
            if($userType=='user'){
                $list['message'] = "Invalid Api method";
                if($apiMethod=="addToFav"){
                    $videoId = $requestInput['videoId'];
                    $list['message'] = "Video not found";
                    $vide = VideoManagementApi::find()->where(['video_id'=>$videoId])->andWhere(['active_status'=>1])->asArray()->one();
                    if(!empty($vide)){
                        $list['message'] = "User not founded";
                        $useMg = AppUsersApi::findOne($userId);
                        if($useMg){
                            $preAr = ArrayHelper::toArray(json_decode($useMg->favVideos));
                            $list['message'] = "Video already added as Favorite.!";
                            if(!in_array($videoId, $preAr)){
                                $preAr[] = $videoId;
                                $useMg->favVideos = json_encode($preAr);
                                if($useMg->save()){
                                    $list['status'] = "success";
                                    $list['message'] = "Video added as Favorite.!";
                                }
                            }
                        }
                    }
                }else if($apiMethod=="removeFromFav"){
                    $videoId = $requestInput['videoId'];
                    $list['message'] = "Video not found";
                    $vide = VideoManagementApi::find()->where(['video_id'=>$videoId])->andWhere(['active_status'=>1])->asArray()->one();
                    if(!empty($vide)){
                        $list['message'] = "User not founded";
                        $useMg = AppUsersApi::findOne($userId);
                        if($useMg){
                            $preAr = ArrayHelper::toArray(json_decode($useMg->favVideos));
                            $list['message'] = "Video not added as Favorite.!";
                            if(in_array($videoId, $preAr)){
                                if (($key = array_search($videoId, $preAr)) !== false) {
                                    unset($preAr[$key]);
                                }
                                $useMg->favVideos = json_encode($preAr);
                                if($useMg->save()){
                                    $list['status'] = "success";
                                    $list['message'] = "Video removed from Favorite.!";
                                }
                            }
                        }
                    }
                }
                 else if($apiMethod=="favoriteList"){
                    $list['message'] = "No videos added";

                    $useMg = AppUsersApi::findOne($userId);
                    if($useMg){
                        $preAr = ArrayHelper::toArray(json_decode($useMg->favVideos));
                        $videoList = VideoManagementApi::find()->where(['active_status'=>1])->andWhere(['IN','video_id',$preAr])->asArray()->all();
                        if(!empty($videoList)){
                            $list['status'] = "success";
                            $list['message'] = "Favorite videos";
                            $list['favVideos'] = $videoList;
                        }
                    }
                }                 
            }
        }
        return $list;
    }
}
