<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category_management".
 *
 * @property integer $auto_id
 * @property string $category_name
 * @property string $category_desc
 * @property integer $category_image
 */
class CategoryManagementApi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'category_desc','active_status','home_status'], 'required'],
            [['category_desc','slug'], 'string'],
            [['category_image','category_icon'], 'string', 'max' => 255],
            
            [['category_image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'category_name' => 'Category Name',
            'slug' => 'slug',
            'category_desc' => 'Category Desc',
            'category_image' => 'Category Image',
        ];
    }

    public function CategoryList($requestInput = array())
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

            $callFrom = $categoryId = $searchString = "";
            if(array_key_exists('categoryId', $requestInput) && $requestInput['categoryId']!=""){
                $categoryId = $requestInput['categoryId'];
            }if(array_key_exists('callFrom', $requestInput) && $requestInput['callFrom']!=""){
                $callFrom = $requestInput['callFrom'];
            }if(array_key_exists('searchString', $requestInput) && $requestInput['searchString']!=""){
                $searchString = $requestInput['searchString'];
            }
            $list['message'] = "Invalid Api Method";
            if($apiMethod=="categoryList"){

                $query = new Query;
                $query -> select('*')->from('category_management');
                $query -> where(['active_status'=>1]);
                if($categoryId!=""){
                    $query->andWhere(['auto_id'=>$categoryId]);
                }if($callFrom=="homeScreen"){
                    $query->andWhere(['home_status'=>1]);
                }if($searchString!=""){
                    $query->andWhere(['LIKE','category_name',$searchString]);
                }

                $apiMgnt = ApiManagementApi::find()->asArray()->all();
                $apiMgnt = ArrayHelper::map($apiMgnt,'apiKey','apiValue');
                $orderBy = "";
                $sort = "SORT_DESC";

                if(!empty($apiMgnt)){
                    if(array_key_exists('categoryListOrderBy', $apiMgnt)){
                        if($apiMgnt['categoryListOrderBy']=='id'){
                            $orderBy = 'auto_id';
                        }if($apiMgnt['categoryListOrderBy']=='name'){
                            $orderBy = 'category_name';
                        }
                    }if(array_key_exists('categoryVideoOrder', $apiMgnt)){
                        if($apiMgnt['categoryVideoOrder']=='DESC'){
                            $sort = "SORT_DESC";
                        }if($apiMgnt['categoryVideoOrder']=='ASE'){
                            $sort = "SORT_ASC";
                        }
                    }
                }
                if($orderBy!="" && $sort!=""){
                    if($sort=='SORT_ASC'){
                        $query->orderBy(["$orderBy"=>SORT_ASC]);
                    }else if($sort=='SORT_DESC'){
                        $query->orderBy(["$orderBy"=>SORT_DESC]);
                    }
                }

                $command = $query->createCommand();
                $cateList = $command->queryAll(); 

                $list['message'] = "No category list founded";
                if(!empty($cateList)){
                    $list['status'] = "success";
                    $list['message'] = "Available List";
                    $list['categories'] = $cateList;
                }
            }
        }
        return $list;
    }
}
