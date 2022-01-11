<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order_management".
 *
 * @property int $orderId
 * @property string $orderCode
 * @property int $userId
 * @property int $prouductId
 * @property int $orderedQuantity
 * @property string $isDelivered
 * @property int $deliveredQuantity
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class OrderManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'prouductId', 'orderedQuantity', 'deliveredQuantity'], 'integer'],
            [['isDelivered'], 'string'],
            [['status'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['orderCode'], 'string', 'max' => 200],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderId' => 'Order ID',
            'orderCode' => 'Order Code',
            'userId' => 'User ID',
            'prouductId' => 'Prouduct ID',
            'orderedQuantity' => 'Ordered Quantity',
            'isDelivered' => 'Is Delivered',
            'deliveredQuantity' => 'Delivered Quantity',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
