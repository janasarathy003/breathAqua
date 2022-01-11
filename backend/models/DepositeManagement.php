<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "deposite_management".
 *
 * @property int $autoId
 * @property int $userId
 * @property int $noOfCanDeposite
 * @property string $isDeposite
 * @property double $depositeAmount
 * @property string $isReturn
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class DepositeManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $userName;
    public static function tableName()
    {
        return 'deposite_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'required'],
            [['userId', 'noOfCanDeposite'], 'integer'],
            [['depositeAmount'], 'number'],
            [['isReturn', 'status'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['isDeposite'], 'string', 'max' => 100],
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
            'noOfCanDeposite' => 'No Of Can Deposite',
            'isDeposite' => 'Is Deposite',
            'depositeAmount' => 'Deposite Amount',
            'isReturn' => 'Is Return',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    public function afterFind() {
        if(isset($this->company)){
            // echo "<prE>";print_r($this->company->name);die;
            $this->userName = $this->company->name; 
        }else{
             $this->userName="-";
        }         
        parent::afterFind();
    }

    public function getCompany()
    {
        return $this->hasOne(UserManagement::className(), ['userId' => 'userId']);
    }
}
