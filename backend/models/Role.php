<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property int $role_name
 * @property string $role_description
 * @property string $active_status 0=In-active,1=Active,2=Delete,3=Reserved
 * @property string $created_at
 * @property string $updated_at
 * @property string $ip_address
 * @property string $system_name
 * @property int $user_id
 * @property string $user_role
 */
class Role extends \yii\db\ActiveRecord
{

    public $hidden_Input;
    public $franchise_type;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['role_description'], 'string'],
            [['created_at', 'updated_at','ref_id','user_type'], 'safe'],
            [['active_status', 'user_role'], 'string', 'max' => 10],
            [['ip_address', 'system_name'], 'string', 'max' => 255],
            [['role_name'],'required']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'role_description' => 'Role Description',
            'active_status' => 'Status',
            'user_type' => 'Franchise Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'ip_address' => 'Ip Address',
            'system_name' => 'System Name',
            'user_id' => 'User ID',
            'ref_id' => 'Franchise Type',
            'user_role' => 'User Role',
        ];
    }
/*public function afterFind() 
    {
        parent::afterFind(); 

        if(isset($this->ref)){
        $this->franchise_type = $this->ref->company_name; 
        }else{
        $this->franchise_type="-";
        } 
    }*/
 /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getRef()
    {
        return $this->hasOne(FranchiseMaster::className(), ['id' => 'ref_id']);
    }*/


}
