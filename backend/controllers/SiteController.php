<?php
namespace backend\controllers;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use common\models\User;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\UserLogin;
use yii\helpers\ArrayHelper;
use common\models\LoginForm;
use yii\filters\AccessControl;
use backend\models\UserActivityLog;
use backend\models\RandomGeneration;

//use backend\models\UserLogin;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {   
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

     

    public function actionIndex()
    {   
        $session = Yii::$app->session;

        $userType = $session['user_type'];
        $status = '';


        return $this->render('index');
    }

    public function actionLogin()
    {

        $this->layout='loginLayout';
        $model = new LoginForm();
        $model1 = new UserLogin();
        if ($model->load(Yii::$app->request->post())) 
        {
            if ($model1->login()) { 
                $username = $_REQUEST['LoginForm']['username'];
                $user_data = UserLogin::find()->where(['OR',['username' => $username],['emailId' => $username]])->one();
                $session = Yii::$app->session;
                $data_array=array('user_id'=>$user_data->id,'message'=>'Login Success','action'=>'Login of '.$user_data->username,'common_master_id'=>$user_data->id,'address'=>$_SERVER['REMOTE_ADDR'],'user_type'=>$session['user_type']);

                $activity_log_insert=new UserActivityLog();
                $activity_log_insert->UserLog($data_array); 
                return $this->goHome();
            }else{
                if ($_REQUEST['LoginForm']['username']!="" && $_REQUEST['LoginForm']['password']) { 
                    Yii::$app->session->setFlash('error', "incorrect username or password"); 
                    $_SESSION['error']="yes"; 
                }
            }
            return $this->refresh();
        } 
        else 
        {  
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
    public function actionLogout()
    {        

        $session = Yii::$app->session;        
        $data_array=array('user_id'=>$session['user_id'],'message'=>'Logout Success','action'=>'Logout of '.$session['user_name'],'common_master_id'=>$session['user_id'],'address'=>$_SERVER['REMOTE_ADDR'],'user_type'=>$session['user_type']);
        $activity_log_insert=new UserActivityLog();
        $activity_log_insert->UserLog($data_array);
        Yii::$app->user->logout();
        $session->destroy();      
        return $this->goHome();
    }
    
}
