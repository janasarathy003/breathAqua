<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ads_settings".
 *
 * @property int $autoId
 * @property string $addFor
 * @property string $addType
 * @property string $addId
 * @property double $referCount
 * @property string $request
 * @property string $Status
 * @property string $createdAt
 * @property string $updatedAt
 */
class AdsSettingsApi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['addFor', 'addId', 'Status'], 'string'],
            [['referCount'], 'number'],
            [['Status'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['addType'], 'string', 'max' => 255],
            [['request'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'autoId' => 'Auto ID',
            'addFor' => 'Add Fro',
            'addType' => 'Add Type',
            'addId' => 'Add ID',
            'referCount' => 'Refer Count',
            'request' => 'Request',
            'Status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    public function AddsDetails($requestInput=array())
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
            if($apiMethod=="adsDetails"){
                $query = new Query;
                $query -> select('*')->from('ads_settings');
                $command = $query->createCommand();
                $adsList = $command->queryAll(); 

                $list['message'] = "Data nto found";
                if(!empty($adsList) ){
                    $resAr = array();
                    foreach ($adsList as $key => $value) {
                        $resAr[$value['addFor']][$value['addType']] = $value;
                    }

                    $andBanSts = $andBanId = $andInterSts = $andInterId = $andInterTrig = $andInterClick = $andNativeSts = $andNativeId = $andNativePos = "";
                    $iosBanSts = $iosBanId = $iosInterSts = $iosInterId = $iosInterTrig = $iosInterClick = $iosNativeSts = $iosNativeId = $iosNativePos = "";
                    $andBanSts = $andInterSts = $andNativeSts = $iosBanSts = $iosInterSts = $iosNativeSts = "disabled";
                    if(!empty($resAr)){
                        if(array_key_exists('android', $resAr)){
                            if(array_key_exists('bannerAds', $resAr['android'])){
                                if(!empty($resAr['android']['bannerAds'])){
                                    // echo "<pre>";print_r($resAr);die;
                                    if($resAr['android']['bannerAds']['Status']=="on"){
                                        $andBanSts = "enabled";
                                    }
                                    $andBanId = $resAr['android']['bannerAds']['addId'];
                                }
                            }if(array_key_exists('interstitialAds', $resAr['android'])){
                                if(!empty($resAr['android']['interstitialAds'])){
                                    if($resAr['android']['interstitialAds']['Status']=="on"){
                                        $andInterSts = "enabled";
                                    }
                                    $andInterId = $resAr['android']['interstitialAds']['addId'];
                                    $andInterTrig = $resAr['android']['interstitialAds']['request'];
                                    $andInterClick = $resAr['android']['interstitialAds']['referCount'];
                                }
                            }if(array_key_exists('nativeAds', $resAr['android'])){
                                if(!empty($resAr['android']['nativeAds'])){
                                    if($resAr['android']['nativeAds']['Status']=="on"){
                                        $andNativeSts = "enabled";
                                    }
                                    $andNativeId = $resAr['android']['nativeAds']['addId'];
                                    $andNativePos = $resAr['android']['nativeAds']['referCount'];
                                }
                            }
                        }
                        if(array_key_exists('ios', $resAr)){
                            if(array_key_exists('bannerAds', $resAr['ios'])){
                                if(!empty($resAr['ios']['bannerAds'])){
                                    if($resAr['ios']['bannerAds']['Status']=="on"){
                                        $iosBanSts = "enabled";
                                    }
                                    $iosBanId = $resAr['ios']['bannerAds']['addId'];
                                }
                            }if(array_key_exists('interstitialAds', $resAr['ios'])){
                                if(!empty($resAr['ios']['interstitialAds'])){
                                    if($resAr['ios']['interstitialAds']['Status']=="on"){
                                        $iosInterSts = "enabled";
                                    }
                                    $iosInterId = $resAr['ios']['interstitialAds']['addId'];
                                    $iosInterTrig = $resAr['ios']['interstitialAds']['request'];
                                    $iosInterClick = $resAr['ios']['interstitialAds']['referCount'];
                                }
                            }if(array_key_exists('nativeAds', $resAr['ios'])){
                                if(!empty($resAr['ios']['nativeAds'])){
                                    if($resAr['ios']['nativeAds']['Status']=="on"){
                                        $iosNativeSts = "enabled";
                                    }
                                    $iosNativeId = $resAr['ios']['nativeAds']['addId'];
                                    $iosNativePos = $resAr['ios']['nativeAds']['referCount'];
                                }
                            }
                        }
                    }
                    $list['message'] = "avaliable List";
                    $list['status'] = "success";

                    $list['androidBannerStatus'] = $andBanSts;
                    $list['androidBannerId'] = $andBanId;
                    $list['androidInterStatus'] = $andInterSts;
                    $list['androidInterId'] = $andInterId;
                    $list['androidInterTriggerType'] = $andInterTrig;
                    $list['androidInterTriggerNumber'] = $andInterClick;
                    $list['androidNativeStatus'] = $andNativeSts;
                    $list['androidNativeId'] = $andNativeId;
                    $list['androidNativePosition'] = $andNativePos;

                    $list['iosBannerStatus'] = $iosBanSts;
                    $list['iosBannerId'] = $iosBanId;
                    $list['iosInterStatus'] = $iosInterSts;
                    $list['iosInterId'] = $iosInterId;
                    $list['iosInterTriggerType'] = $iosInterTrig;
                    $list['iosInterTriggerNumber'] = $iosInterClick;
                    $list['iosNativeStatus'] = $iosNativeSts;
                    $list['iosNativeId'] = $iosNativeId;
                    $list['iosNativePosition'] = $iosNativePos;
                }
            }
        }
        return $list;
    }
}
