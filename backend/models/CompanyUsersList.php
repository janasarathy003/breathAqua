<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "company_users_list".
 *
 * @property int $autoId
 * @property int $userId
 * @property string $name
 * @property string $phoneNo
 * @property string $alternatePhoneNo
 * @property string $mailId
 * @property string $blockNo
 * @property string $floorNo
 * @property string $departmentName
 * @property string $designationName
 * @property string $detailedAddress
 * @property string $deliveryFrequency
 * @property int $noOfCansPerVisit
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class CompanyUsersList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $companyName;
    public static function tableName()
    {
        return 'company_users_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'name', 'phoneNo', 'status'], 'required'],
            [['userId', 'noOfCansPerVisit'], 'integer'],
            [['detailedAddress', 'deliveryFrequency', 'status'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name', 'departmentName', 'designationName'], 'string', 'max' => 255],
            [['phoneNo', 'alternatePhoneNo', 'blockNo', 'floorNo'], 'string', 'max' => 100],
            [['mailId'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'autoId' => 'Auto ID',
            'userId' => 'User ID',
            'name' => 'Name',
            'phoneNo' => 'Phone No',
            'alternatePhoneNo' => 'Alternate Phone No',
            'mailId' => 'Mail ID',
            'blockNo' => 'Block No',
            'floorNo' => 'Floor No',
            'departmentName' => 'Department Name',
            'designationName' => 'Designation Name',
            'detailedAddress' => 'Detailed Address',
            'deliveryFrequency' => 'Delivery Frequency',
            'noOfCansPerVisit' => 'No Of Cans Per Visit',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    public function afterFind() {
        if(isset($this->company)){
            // echo "<prE>";print_r($this->company->name);die;
            $this->companyName = $this->company->name; 
        }else{
             $this->companyName="-";
        }         
        parent::afterFind();
    }

    public function getCompany()
    {
        return $this->hasOne(UserManagement::className(), ['userId' => 'userId']);
    }
}
