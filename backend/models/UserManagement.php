<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_management".
 *
 * @property int $userId
 * @property string $userType
 * @property string $name
 * @property string $phoneNo
 * @property string $alternatePhoneNo
 * @property string $mailId
 * @property string $referalCode
 * @property string $googleLocation
 * @property string $address
 * @property string $blockNo
 * @property string $floorNo
 * @property string $detailedAddress
 * @property string $deliveryFrequency
 * @property int $noOfCansPerVisit
 * @property int $noOfCansDeposite
 * @property double $userPrice
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class UserManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userType', 'name', 'phoneNo'], 'required'],
            [['address', 'detailedAddress', 'deliveryFrequency', 'status'], 'string'],
            [['noOfCansPerVisit', 'noOfCansDeposite'], 'integer'],
            [['userPrice'], 'number'],
            [['mailId'], 'email'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['userType', 'phoneNo', 'alternatePhoneNo', 'referalCode'], 'string', 'max' => 100],
            [['name', 'googleLocation'], 'string', 'max' => 255],
            [['blockNo', 'floorNo'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'userType' => 'User Type',
            'name' => 'Name',
            'phoneNo' => 'Phone No',
            'alternatePhoneNo' => 'Alternate Phone No',
            'mailId' => 'Mail ID',
            'referalCode' => 'Referal Code',
            'googleLocation' => 'Google Location',
            'address' => 'Address',
            'blockNo' => 'Block No',
            'floorNo' => 'Floor No',
            'detailedAddress' => 'Detailed Address',
            'deliveryFrequency' => 'Delivery Frequency',
            'noOfCansPerVisit' => 'No Of Cans Per Visit',
            'noOfCansDeposite' => 'No Of Cans Deposite',
            'userPrice' => 'User Price',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
