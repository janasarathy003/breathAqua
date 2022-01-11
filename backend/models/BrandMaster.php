<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand_master".
 *
 * @property int $brandId
 * @property string $brandName
 * @property double $mrp
 * @property double $halfPrice
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class BrandMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brandName', 'status'], 'required'],
            [['mrp', 'halfPrice'], 'number'],
            [['status'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['brandName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'brandId' => 'Brand',
            'brandName' => 'Brand Name',
            'mrp' => 'Mrp',
            'halfPrice' => 'Half Price',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
