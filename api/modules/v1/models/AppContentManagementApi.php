<?php


namespace api\modules\v1\models;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "app_content_management".
 *
 * @property int $autoId
 * @property string $contentKey
 * @property string $contentValue
 * @property string $createdAt
 * @property string $updatedAt
 */
class AppContentManagementApi extends \yii\db\ActiveRecord
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

    public function AppContent($requestInput=array())
    {
        $list['status'] = 'error';
        $list['message'] = 'Invalid ';
        $field_check=array('apiMethod');
        
        $is_error = '';
        foreach ($field_check as $one_key) {
            $key_val =isset($requestInput[$one_key]);
            if ($key_val == '') {
                $is_error = 'yes';
                $is_error_note = $one_key;
                break;
            }
        } 
        if ($is_error == "yes") {
            $list['status'] = 'error';
            $list['message'] = $is_error_note . ' is Mandatory.';
        }else{
            $apiMethod = $requestInput['apiMethod'];
            
            $list['message'] = "Invalid Api method";
            if($apiMethod=="appContent"){
                $list['message'] = "Content not found";
                $appCont = AppContentManagementApi::find()->asArray()->all();
                $appContAr = ArrayHelper::map($appCont,'contentKey','contentValue');
                if(!empty($appContAr)){
                    $list['status'] = "success";
                    $list['message'] = "Available Content";

                    foreach ($appContAr as $key => $value) {
                        $list[$key] = $value; 
                    }
                }
            }
        }
        return $list;
    }
}
