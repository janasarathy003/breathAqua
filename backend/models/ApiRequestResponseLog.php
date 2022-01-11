<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "api_request_response_log".
 *
 * @property int $autoid
 * @property string $apiMethod
 * @property string $requestData
 * @property string $response
 * @property string $createdAt
 * @property string $mobileCode
 * @property string $updatedAt
 */
class ApiRequestResponseLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_request_response_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requestData', 'response', 'mobileCode'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['apiMethod'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'autoid' => 'Autoid',
            'apiMethod' => 'Api Method',
            'requestData' => 'Request Data',
            'response' => 'Response',
            'createdAt' => 'Created At',
            'mobileCode' => 'Mobile Code',
            'updatedAt' => 'Updated At',
        ];
    }
}
