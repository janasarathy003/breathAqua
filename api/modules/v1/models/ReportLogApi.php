<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "report_log".
 *
 * @property int $reportId
 * @property int $userId
 * @property int $videoId
 * @property string $report
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class ReportLogApi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'videoId'], 'integer'],
            [['report'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['status'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reportId' => 'Report ID',
            'userId' => 'User ID',
            'videoId' => 'Video ID',
            'report' => 'Report',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    public function ReportsMgnt($requestInput=array())
    {
        $list['status'] = 'error';
        $list['message'] = 'Invalid ';
        $field_check=array('apiMethod');
        if(array_key_exists('apiMethod', $requestInput)){
            if($requestInput['apiMethod']=='addReport'){
                $field_check=array('apiMethod','videoId','userId','userType','report');
            }if($requestInput['apiMethod']=='removeReport'){
                $field_check=array('apiMethod','videoId','userId','userType');
            }
        }
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
            $userType = $requestInput['userType'];

            $list['message'] = "login required to access this feature.!";
            if($userType=='user'){
                $list['message'] = "Invalid Api method";
                if($apiMethod=="addReport"){
                    $userId = $requestInput['userId'];
                    $userType = $requestInput['userType'];
                    $videoId = $requestInput['videoId'];
                    $report = $requestInput['report'];

                    $list['message'] = "Video not found";
                    $vide = VideoManagementApi::find()->where(['video_id'=>$videoId])->andWhere(['active_status'=>1])->asArray()->one();
                    if(!empty($vide)){
                        $newReport = new ReportLogApi();
                        $newReport->userId = $userId;
                        $newReport->videoId = $videoId;
                        $newReport->report = $report;
                        $newReport->status = "reported";
                        $newReport->createdAt = date("Y-m-d H:i:s");
                        $newReport->updatedAt = date("Y-m-d H:i:s");
                        if($newReport->save()){
                            $list['status'] = "success";
                            $list['message'] = "Report submitted successfully";
                        }else{
                            echo "<pre>";print_r($newReport->getErrors());die;
                        }
                    }
                }else if($apiMethod=="removeReport"){
                    $userId = $requestInput['userId'];
                    $videoId = $requestInput['videoId'];

                    $list['message'] = "Video not found";
                    $vide = VideoManagementApi::find()->where(['video_id'=>$videoId])->andWhere(['active_status'=>1])->asArray()->one();
                    if(!empty($vide)){

                        $list['message'] = "Report not found";
                        $oldReport = ReportLogApi::find()->where(['videoId'=>$videoId])->andWhere(['userId'=>$userId])->andWhere(['status'=>'reported'])->one();
                        if($oldReport){
                            $oldReport->status = "removed";
                            if($oldReport->save()){
                                $list['status'] = "success";
                                $list['message'] = "Report removed successfully";
                            }else{
                                echo "<pre>";print_r($oldReport->getErrors());die;
                            }
                        }                    
                    }
                }
            }
        }
        return $list;
    }
}
