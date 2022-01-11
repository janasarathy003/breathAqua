<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "role_manage".
 *
 * @property int $id
 * @property int $role_id
 * @property string $role_rights
 * @property string $active_status 0=In-active,1=Active,2=Delete,3=Reserved
 * @property string $created_at
 * @property string $updated_at
 * @property string $ip_address
 * @property string $system_name
 * @property int $user_id
 * @property string $user_role
 */
class RoleManage extends \yii\db\ActiveRecord
{
    public $hidden_Input;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_manage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'user_id'], 'integer'],
            [['role_rights'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
           // [['user_role'], 'required'],
            [['active_status'], 'string', 'max' => 10],
            [['ip_address', 'system_name'], 'string', 'max' => 255],
            [['user_role'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'role_rights' => 'Role Rights',
            'active_status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'ip_address' => 'Ip Address',
            'system_name' => 'System Name',
            'user_id' => 'User ID',
            'user_role' => 'User Role',
        ];
    }
}
