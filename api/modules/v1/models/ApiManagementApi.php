<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "api_management".
 *
 * @property int $apiId
 * @property string $apiKey
 * @property string $apiValue
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class ApiManagementApi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apiValue'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['apiKey'], 'string', 'max' => 250],
            [['status'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'apiId' => 'Api ID',
            'apiKey' => 'Api Key',
            'apiValue' => 'Api Value',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
