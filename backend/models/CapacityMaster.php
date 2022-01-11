<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "capacity_master".
 *
 * @property int $capacityId
 * @property string $capacityName
 * @property string $unit
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class CapacityMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'capacity_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['capacityName', 'status'], 'required'],
            [['status'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['capacityName'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'capacityId' => 'Capacity ID',
            'capacityName' => 'Capacity Name',
            'unit' => 'Unit',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
