<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sms_log".
 *
 * @property int $id
 * @property string $message
 * @property string $number
 * @property string $createddate
 * @property string $modifieddate
 * @property string $updatedipaddress
 * @property string $responselog
 */
class SmsLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'responselog'], 'string'],
            [['createddate', 'modifieddate'], 'safe'],
            [['number'], 'string', 'max' => 100],
            [['updatedipaddress'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'number' => 'Number',
            'createddate' => 'Createddate',
            'modifieddate' => 'Modifieddate',
            'updatedipaddress' => 'Updatedipaddress',
            'responselog' => 'Responselog',
        ];
    }
}
