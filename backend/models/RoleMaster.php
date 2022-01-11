<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "role_master".
 *
 * @property int $role_id
 * @property string $role_name
 * @property string $description
 * @property int $active_status
 * @property string $created_at
 * @property string $updated_at
 * @property string $ip_address
 * @property string $system_name
 * @property int $user_id
 */
class RoleMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active_status', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['role_name', 'description', 'ip_address', 'system_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'role_name' => 'Role Name',
            'description' => 'Description',
            'active_status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'ip_address' => 'Ip Address',
            'system_name' => 'System Name',
            'user_id' => 'User ID',
        ];
    }
}
