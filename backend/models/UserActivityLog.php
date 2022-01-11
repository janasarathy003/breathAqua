<?php

namespace backend\models;

use common\models\User;
use backend\models\UserLogin;


use Yii;

/**
 * This is the model class for table "user_activity_log".
 *
 * @property string $id
 * @property string $user_id
 * @property string $activity_message
 * @property string $action
 * @property string $common_master_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $server_address
 */
class UserActivityLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_activity_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'common_master_id'], 'integer'],
            [['created_at', 'updated_at','activity_message', 'action'], 'safe'],
            [['server_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'activity_message' => 'Activity Message',
            'action' => 'Action',
            'common_master_id' => 'Common Master ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'server_address' => 'Server Address',
        ];
    }


    public function UserLog($data_array=array())
    {
        
        $activity_log_insert=new UserActivityLog();
        $activity_log_insert->user_id=$data_array['user_id'];
        $activity_log_insert->activity_message=$data_array['message'];
        $activity_log_insert->action=$data_array['action'];
        $activity_log_insert->common_master_id=$data_array['common_master_id'];
        $activity_log_insert->server_address=$data_array['address'];
        $activity_log_insert->system_name=gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $activity_log_insert->user_role=$data_array['user_type'];
        
        $activity_log_insert->created_at=date('Y-m-d H:i:s');
        $activity_log_insert->updated_at=date('Y-m-d H:i:s');

        if($activity_log_insert->save())
        {

        }
        else
        {
            Yii::$app->getSession()->setFlash('danger', 'Activity Log Module Not Insert');    
        } 
    }

    public function UserLogHistory($user_details='',$user_type='',$created_at='',$updated_at='',$ip_address='',$system_name='')
    {
        $sent_data_array=array();

        $sent_data_array['username']='';
        if($user_type == 'A')
        {
            $user_admin=User::findOne($user_details);

            $sent_data_array['username']=strtoupper($user_admin->username);

        }
        else if($user_type == 'NA')
        {
            $user_non_admin=UserLogin::findOne($user_details);

            $sent_data_array['username']=strtoupper($user_non_admin->username);
        }
        
        $sent_data_array['created_at']=date('d-m-Y',strtotime($created_at));
        $sent_data_array['updated_at']=date('d-m-Y',strtotime($updated_at));
        $sent_data_array['ip_address']=$ip_address;
        $sent_data_array['system_name']=strtoupper($system_name);

        return $sent_data_array;
    }


}
