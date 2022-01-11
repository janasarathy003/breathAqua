<?php
namespace frontend\controllers;
// error_reporting(E_ALL ^ E_NOTICE); 
use Yii;
use backend\models\UserLogin;
//use common\models\UserLogin;
use yii\helpers\Url;
use yii\web\Session; 
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
/**
 * Site controller
 */
class SiteController extends Controller
{ 
    /**
     * @inheritdoc
     */ 
    public function behaviors()
    {
        return [
            /*'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }


    public function beforeAction($action) {

        $session = Yii::$app->session;
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actions()
    {       
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {  
        $attributes = $client->getUserAttributes();  //echo "<pre>"; print_r($attributes); die;
        $mail=$attributes['email'];
        if (array_key_exists('given_name', $attributes)) {
            $type="gmail";
        }else {
            $type="facebook";
        }
          
        $model = new UserManagementLogin();
        if($model->login($attributes,$type)){
            return $this->redirect(['listings']);
        }else{
            $session = Yii::$app->session;
            Yii::$app->user->logout(); 
            $session->destroy();
            return $this->goHome();
        }
    }
    public function oAuthSuccess($client) {
        $userAttributes = $client->getUserAttributes();
       // echo $userAttributes['email']; die;
    }
   
    public function getRandomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = '';       
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        }       
        return $randomString; 
    }

    public function actionIndex()
    { 
        return $this->redirect('backend/web/index.php');            
    }

    # Login PAge 
    public function actionLogin($error=""){
        $this->layout="main";
        $model = new MerchantMaster();
        $model1 = new UserManagement();
        return $this->render('login',['error'=>$error,'model'=>$model,'model1'=>$model1]);
    }

}