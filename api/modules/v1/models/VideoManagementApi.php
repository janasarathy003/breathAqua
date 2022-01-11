<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "video_management".
 *
 * @property integer $video_id
 * @property string $youtube_url
 * @property string $you_desc
 * @property integer $auto_id
 * @property integer $active_status
 */
class VideoManagementApi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;
    public $category_name;
    public static function tableName()
    {
        return 'video_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['youtube_url', 'auto_id','youtube_id','active_status','video_name'], 'required'],
            [['auto_id', 'active_status'], 'integer'],
            [[ 'video_name','video_type','viewcount','defaultt','medium','high','you_desc','standard','publish_date','last_notify_date'], 'safe'],
             [['video_image'], 'string', 'max' => 255],
            [['youtube_url'], 'string', 'max' => 255],
             [['video_image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'video_name'=>'Video Name',
            'video_id' =>'Video ID',
            'youtube_url'=>'Youtube Link',
            'you_desc' =>'Description',
            'auto_id' => 'Category',
            'video_type'=>'Favourite',


           // 'active_status' => 'Active Status',
        ];
    }

    public function afterFind() {
        if(isset($this->lead)){
            $this->category_name = $this->lead->category_name; 
        }else{

             $this->category_name="-";
        }
        $this->video_name =stripslashes($this->video_name); 
        parent::afterFind();
    }

    public function getLead()
    {
        //TansiLeadManagement
        return $this->hasOne(CategoryManagement::className(), ['auto_id' =>'auto_id']);
    }

    function convert_time($str) 
    {
        $n = strlen($str);
        $ans = 0;
        $curr = 0;
        for($i=0; $i<$n; $i++)
        {
            if($str[$i] == 'P' || $str[$i] == 'T')
            {

            }
            else if($str[$i] == 'H')
            {
                $ans = $ans + 3600*$curr;
                $curr = 0;
            }
            else if($str[$i] == 'M')
            {
                $ans = $ans + 60*$curr;
                $curr = 0;
            }
            else if($str[$i] == 'S')
            {
                $ans = $ans + $curr;
                $curr = 0;
            }
            else
            {
                $curr = 10*$curr + $str[$i];
            }
        }
        if($ans>=3600){
            $ans1 = gmdate("H:i:s", $ans);
        }else{
            $ans1 = gmdate("i:s", $ans);

        }
        return($ans1);
    }

    function time_elapsed_string($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function VideoList($requestInput = array())
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
            $requestCall = $videoId = $categoryId = $searchString = "";
            if(array_key_exists('videoId', $requestInput)){
                $videoId = $requestInput['videoId'];
            }if(array_key_exists('requestCall', $requestInput)){
                $requestCall = $requestInput['requestCall'];
            }if(array_key_exists('categoryId', $requestInput)){
                $categoryId = $requestInput['categoryId'];
            }if(array_key_exists('searchString', $requestInput)){
                $searchString = $requestInput['searchString'];
            }
            $pageNo = 1;
            if(array_key_exists('pageNo', $requestInput)){
                if($requestInput['pageNo']!=""){
                    $pageNo = $requestInput['pageNo'];
                }
            }
            $list['message'] = "Invalid Api method";

            // echo die;

            if($apiMethod=="videoList"){
                $favVideos = array();
                if(array_key_exists('userId', $requestInput)){
                    if($requestInput['userId']!=""){
                        $useMg = AppUsersApi::findOne($requestInput['userId']);
                        $favVideos = ArrayHelper::toArray(json_decode($useMg->favVideos));

                    }
                }

                $query = new Query;
                $query -> select('*')->from('video_management');
                $query -> where(['active_status'=>1]);
                if($videoId!=""){
                    $query->andWhere(['video_id'=>$videoId]);
                }if($categoryId!=""){
                    $query->andWhere(['categoryId'=>$categoryId]);
                }if($searchString!=""){
                    $query->andWhere(['OR',['like','video_name',$searchString],['LIKE','videoTags',$searchString]]);
                }

                $apiMgnt = ApiManagementApi::find()->asArray()->all();
                $apiMgnt = ArrayHelper::map($apiMgnt,'apiKey','apiValue'); 

                if($requestCall=='bannerVideos'){
                    $query->andWhere(['video_type'=>'Yes']);
                }
                if($requestCall=='latestVideos'){
                    $query->orderBy(['video_id'=>SORT_DESC]);
                    if(array_key_exists('latestLimit', $apiMgnt)){
                        if($apiMgnt['latestLimit']!=""){
                            $query->limit($apiMgnt['latestLimit']);
                        }
                    }
                }else{
                    if(array_key_exists('allVideoOrder', $apiMgnt)){
                        if($apiMgnt['allVideoOrder']=="ASC"){
                            $query->orderBy(['video_id'=>SORT_ASC]);
                        }else if($apiMgnt['allVideoOrder']=="DESC"){
                            $query->orderBy(['video_id'=>SORT_DESC]);
                        }
                    }
                }
                if($requestCall=='allVideos'){
                    $limit = 10;
                    $startWith = 0;
                    if($pageNo>1){
                        $startWith = $limit*($pageNo-1);
                    }
                    $query->limit($limit);
                    $query->offset($startWith);
                }

                $command = $query->createCommand();
                $videoList = $command->queryAll(); 

                if($videoId!=""){
                    $cateId = "";
                }

                $categoriesList = array();
                if($searchString!=""){
                    $inpt = array();
                    $inpt["apiMethod"] = "categoryList";
                    $inpt["searchString"] = $searchString;
                    $newList = new CategoryManagementApi();
                    $categories = $newList->CategoryList($inpt);
                    if(!empty($categories)){
                        if(array_key_exists('status', $categories) && $categories['status']=='success'){
                            if(array_key_exists('categories', $categories) && !empty($categories['categories'])){
                                $list['message'] = "success";
                                $list['message'] = "search result";
                                $categoriesList = $categories['categories'];
                            }
                        }
                    }
                }

                $list['message'] = "Vidos not available";
                if(!empty($videoList) ){
                    $videoListAr = array();
                    foreach ($videoList as $key => $value) {
                        if($videoId!=""){
                            $cateId = $value['categoryId'];
                        }
                        $value['isFavVideo'] = "no";
                        if(!empty($favVideos)){
                            if(in_array($value["video_id"], $favVideos)){
                                $value['isFavVideo'] = "yes";
                            }
                        }
                        $duration = "";
                        if(array_key_exists('youtubeResponse', $value)){
                            $result = $value['youtubeResponse'];
                            $result = json_decode($result);
                            $result = ArrayHelper::toArray($result);
                            if(array_key_exists('items', $result)){

                                $items_column = ArrayHelper::getColumn($result['items'],'contentDetails');
                                $items_columnqq = ArrayHelper::getColumn($items_column,'duration');
                                if(!empty($items_columnqq)){
                                    if(array_key_exists(0, $items_columnqq) && $items_columnqq[0]!=""){
                                        $duration = $this->convert_time($items_columnqq[0]);
                                    }
                                }                                
                            }
                        }
                        $value['duration'] = $duration;
                        $publish = date("d-m-Y H:i:s",strtotime($value['publish_date']));
                        $value['publish_date'] = $publish;
                        $daysAgo = $this->time_elapsed_string($publish);
                        $value['daysAgo'] = $daysAgo;

                        $videoListAr[] = $value;
                    }

                    if($videoId!=""){
                        $relatedVideos = array();
                        $query = new Query;
                        $query -> select('*')->from('video_management');
                        $query -> where(['active_status'=>1]);
                        if($cateId!=""){
                            $query->andWhere(['categoryId'=>$cateId]);
                        }

                        $apiMgnt = ApiManagementApi::find()->asArray()->all();
                        $apiMgnt = ArrayHelper::map($apiMgnt,'apiKey','apiValue'); 
                        if(array_key_exists('allVideoOrder', $apiMgnt)){
                            if($apiMgnt['allVideoOrder']=="ASC"){
                                $query->orderBy(['video_id'=>SORT_ASC]);
                            }else if($apiMgnt['allVideoOrder']=="DESC"){
                                $query->orderBy(['video_id'=>SORT_DESC]);
                            }
                        }
                        $command = $query->createCommand();
                        $relatedVideos = $command->queryAll(); 

                        $relatedVidsAr = array();
                        if(!empty($relatedVideos)){
                            foreach ($relatedVideos as $key => $value) {
                                if($value['video_id']!=$videoId){
                                    $value['isFavVideo'] = "no";
                                    if(!empty($favVideos)){
                                        if(in_array($value["video_id"], $favVideos)){
                                            $value['isFavVideo'] = "yes";
                                        }
                                    }
                                    $duration = "";
                                    if(array_key_exists('youtubeResponse', $value)){
                                        $result = $value['youtubeResponse'];
                                        $result = json_decode($result);
                                        $result = ArrayHelper::toArray($result);
                                        if(array_key_exists('items', $result)){

                                            $items_column = ArrayHelper::getColumn($result['items'],'contentDetails');
                                            $items_columnqq = ArrayHelper::getColumn($items_column,'duration');
                                            if(!empty($items_columnqq)){
                                                if(array_key_exists(0, $items_columnqq) && $items_columnqq[0]!=""){
                                                    $duration = $this->convert_time($items_columnqq[0]);
                                                }
                                            }                                
                                        }
                                    }
                                    $value['duration'] = $duration;
                                    $value['duration'] = $duration;
                                    $publish = date("d-m-Y H:i:s",strtotime($value['publish_date']));
                                    $value['publish_date'] = $publish;
                                    $daysAgo = $this->time_elapsed_string($publish);
                                    $value['daysAgo'] = $daysAgo;
                                    $relatedVidsAr[] = $value;
                                }
                            }                            
                        }
                    }                    

                    $list['message'] = "avaliable Videos";
                    $list['status'] = "success";
                    $list['pageNo'] = $pageNo;
                    $list['videos'] = $videoListAr;
                    if($videoId!=""){
                        $list['relatedVideos'] = $relatedVidsAr;
                    }
                }elseif ($searchString!="") {
                    $videoListAr = array();
                    $list['message'] = "search results";
                    $list['status'] = "success";
                    $list['pageNo'] = "1";
                    $list['videos'] = $videoListAr;
                    $list['categories'] = $categoriesList;
                }                
            }else if($apiMethod=='searchSuggession'){
                $searchString = "";
                if(array_key_exists('searchString', $requestInput)){
                    $searchString = $requestInput['searchString'];
                }

                $inpt = array();
                $inpt["apiMethod"] = "categoryList";
                $inpt["searchString"] = $searchString;
                $newList = new CategoryManagementApi();
                $categories = $newList->CategoryList($inpt);

                $inpt = array();
                $inpt["apiMethod"] = "videoList";
                $inpt["searchString"] = $searchString;
                $videos = $this->VideoList($inpt);

                $categNames = $videoNames = array();
                $list['message'] = "No suggestion founded.!";

                if(!empty($videos)){
                    if($videos['status']=='success'){
                        if(array_key_exists('videos', $videos)){
                            if(!empty($videos['videos'])){
                                $videoNames = ArrayHelper::getColumn($videos['videos'],'video_name');
                            }
                        }
                    }
                }if(!empty($categories)){
                    if($categories['status']=='success'){
                        if(array_key_exists('categories', $categories)){
                            if(!empty($categories['categories'])){
                                $categNames = ArrayHelper::getColumn($categories['categories'],'category_name');
                            }
                        }
                    }
                }

                if(!empty($categNames) || !empty($videoNames)){
                    $list['status'] = "success";
                    $list['message'] = "Suggested names.!";

                    $suggestAr = array();
                    $suggestAr = array_merge($suggestAr,$categNames);
                    $suggestAr = array_merge($suggestAr,$videoNames);
                    shuffle($suggestAr);
                    $list['sugesstions'] = $suggestAr;
                    // echo "<pre>";print_r($suggestAr);die;
                }






            }
        }
        return $list;
    }

    public function HomeScreenApk($requestInput = array())
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
            if($apiMethod=="homeScreenApk"){

                
                # get Banner Videos
                $banerVideos = array();
                $inp = array();
                $inp['apiMethod'] = "videoList";
                $inp['requestCall'] = "bannerVideos";
                $resFrom = $this->VideoList($inp);
                if(!empty($resFrom)){
                    if(array_key_exists('videos', $resFrom)){
                        $banerVideos = $resFrom['videos'];
                    }
                }

                # get Latest Videos
                $latestVideos = array();
                $inp = array();
                $inp['apiMethod'] = "videoList";
                $inp['requestCall'] = "latestVideos";
                $resFrom1 = $this->VideoList($inp);
                if(!empty($resFrom1)){
                    if(array_key_exists('videos', $resFrom1)){
                        $latestVideos = $resFrom1['videos'];
                    }
                }

                # get Category List
                $categoryList = array();
                $inp = array();
                $inp['apiMethod'] = "categoryList";
                $inp['callFrom'] = "homeScreen";
                $cate = new CategoryManagementApi();
                $resFrom2 = $cate->CategoryList($inp);
                if(!empty($resFrom2)){
                    if(array_key_exists('categories', $resFrom2)){
                        $categoryList = $resFrom2['categories'];
                    }
                }

                # get Total videos and Categories count
                $totalVideos = VideoManagementApi::find()->where(['active_status'=>1])->count();
                $totalCategories = CategoryManagementApi::find()->where(['active_status'=>1])->count();

                # get Ads Informations

                $adsInfo = array();
                $inp = array();
                $inp['apiMethod'] = "adsDetails";
                $cate = new AdsSettingsApi();
                $resFrom3 = $cate->AddsDetails($inp);
                // echo "<pre>";print_r($resFrom3);die;
                $andBanSts = $andBanId = $andInterSts = $andInterId = $andInterTrig = $andInterClick = $andNativeSts = $andNativeId = $andNativePos = "";
                $iosBanSts = $iosBanId = $iosInterSts = $iosInterId = $iosInterTrig = $iosInterClick = $iosNativeSts = $iosNativeId = $iosNativePos = "";
                $andBanSts = $andInterSts = $andNativeSts = $iosBanSts = $iosInterSts = $iosNativeSts = "disabled";
                if(!empty($resFrom3)){
                    if($resFrom3['status']=='success'){

                        if(array_key_exists('androidBannerStatus', $resFrom3)){
                            $andBanSts = $resFrom3['androidBannerStatus'];
                        }if(array_key_exists('androidBannerId', $resFrom3)){
                            $andBanId = $resFrom3['androidBannerId'];
                        }if(array_key_exists('androidInterStatus', $resFrom3)){
                            $andInterSts = $resFrom3['androidInterStatus'];
                        }if(array_key_exists('androidInterId', $resFrom3)){
                            $andInterId = $resFrom3['androidInterId'];
                        }if(array_key_exists('androidInterTriggerType', $resFrom3)){
                            $andInterTrig = $resFrom3['androidInterTriggerType'];
                        }if(array_key_exists('androidBannerStatus', $resFrom3)){
                            $andInterClick = $resFrom3['androidInterTriggerNumber'];
                        }if(array_key_exists('androidInterTriggerNumber', $resFrom3)){
                            $andNativeSts = $resFrom3['androidNativeStatus'];
                        }if(array_key_exists('androidNativeId', $resFrom3)){
                            $andNativeId = $resFrom3['androidNativeId'];
                        }if(array_key_exists('androidNativePosition', $resFrom3)){
                            $andNativePos = $resFrom3['androidNativePosition'];
                        }

                        if(array_key_exists('iosBannerStatus', $resFrom3)){
                            $iosBanSts = $resFrom3['iosBannerStatus'];
                        }if(array_key_exists('iosBannerId', $resFrom3)){
                            $iosBanId = $resFrom3['iosBannerId'];
                        }if(array_key_exists('iosInterStatus', $resFrom3)){
                            $iosInterSts = $resFrom3['iosInterStatus'];
                        }if(array_key_exists('iosInterId', $resFrom3)){
                            $iosInterId = $resFrom3['iosInterId'];
                        }if(array_key_exists('iosInterTriggerType', $resFrom3)){
                            $iosInterTrig = $resFrom3['iosInterTriggerType'];
                        }if(array_key_exists('iosBannerStatus', $resFrom3)){
                            $iosInterClick = $resFrom3['iosInterTriggerNumber'];
                        }if(array_key_exists('iosInterTriggerNumber', $resFrom3)){
                            $iosNativeSts = $resFrom3['iosNativeStatus'];
                        }if(array_key_exists('iosNativeId', $resFrom3)){
                            $iosNativeId = $resFrom3['iosNativeId'];
                        }if(array_key_exists('iosNativePosition', $resFrom3)){
                            $iosNativePos = $resFrom3['iosNativePosition'];
                        }

                    }
                }

                $list['status'] = "success";
                $list['message'] = "Home Screen informations";
                $list['bannerVideos'] = $banerVideos;
                $list['categoryList'] = $categoryList;
                $list['latestVideos'] = $latestVideos;
                $list['totalVideos'] = $totalVideos;
                $list['totalCategories'] = $totalCategories;

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
        return $list;
    }
    
}
