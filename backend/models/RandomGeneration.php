<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "random_generation".
 *
 * @property int $id
 * @property string $key_id
 * @property string $random_number
 * @property string $created_at
 * @property string $update_at
 * @property string $ip_address
 * @property string $system_name
 * @property int $user_id
 */
class RandomGeneration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'random_generation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'update_at'], 'safe'],
            [['user_id'], 'safe'],
            [['key_id', 'random_number', 'ip_address', 'system_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key_id' => 'Key ID',
            'random_number' => 'Random Number',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'ip_address' => 'Ip Address',
            'system_name' => 'System Name',
            'user_id' => 'User ID',
        ];
    }
}
