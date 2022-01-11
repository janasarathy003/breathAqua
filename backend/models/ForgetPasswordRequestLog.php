<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "forget_password_request_log".
 *
 * @property int $autoId
 * @property string $requestType
 * @property int $referenceId
 * @property string $mailId
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $updatedIpAddress
 */
class ForgetPasswordRequestLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forget_password_request_log';
    }

    /**
     * @inheritdoc
     */
   public function rules()
    {
        return [
            [['requestType', 'status'], 'safe'],
            [['referenceId'], 'safe'],
            [['status'], 'safe'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['mailId'], 'safe'],
            [['updatedIpAddress'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'autoId' => 'Auto ID',
            'requestType' => 'Request Type',
            'referenceId' => 'Reference ID',
            'mailId' => 'Mail ID',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'updatedIpAddress' => 'Updated Ip Address',
        ];
    }
}
