<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "version_control".
 *
 * @property int $id
 * @property double $version_name
 * @property string $created_at
 * @property string $updated_at
 * @property string $ip_address
 * @property string $system_name
 * @property int $user_id
 * @property string $user_role
 */
class VersionControl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'version_control';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version_name'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'integer'],
            [['ip_address', 'system_name', 'user_role'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'version_name' => 'Version Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'ip_address' => 'Ip Address',
            'system_name' => 'System Name',
            'user_id' => 'User ID',
            'user_role' => 'User Role',
        ];
    }
}
