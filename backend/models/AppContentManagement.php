<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "app_content_management".
 *
 * @property int $autoId
 * @property string $contentKey
 * @property string $contentValue
 * @property string $createdAt
 * @property string $updatedAt
 */
class AppContentManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_content_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contentValue'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['contentKey'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'autoId' => 'Auto ID',
            'contentKey' => 'Content Key',
            'contentValue' => 'Content Value',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
