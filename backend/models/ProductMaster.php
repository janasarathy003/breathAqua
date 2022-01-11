<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_master".
 *
 * @property int $productId
 * @property string $productName
 * @property int $capacityId
 * @property string $capacity
 * @property int $brandId
 * @property string $brandName
 * @property double $basePrice
 * @property double $halfPrice
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class ProductMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productName'], 'required'],
            [['capacityId', 'brandId'], 'integer'],
            [['basePrice', 'halfPrice'], 'number'],
            [['status'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['productName'], 'string', 'max' => 255],
            [['capacity', 'brandName'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'productId' => 'Product',
            'productName' => 'Product Name',
            'capacityId' => 'Capacity',
            'capacity' => 'Capacity',
            'brandId' => 'Brand',
            'brandName' => 'Brand Name',
            'basePrice' => 'Base Price',
            'halfPrice' => 'Half Price',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
