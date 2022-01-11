<?php

namespace backend\controllers;

use Yii;
use backend\models\UserLogin;
use backend\models\RandomGeneration;
use backend\models\Role;
use backend\models\UserLoginSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserLoginController implements the CRUD actions for UserLogin model.
 */
class UserLoginController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserLogin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserLoginSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserLogin model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserLogin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserLogin();

        if (Yii::$app->request->post()) {
            if(Yii::$app->request->isAjax){
                //$uniquemdel = new MerchantCategoryMasterUnique();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);  
            }
            $model->name = $_POST['UserLogin']['name'];
            $model->contactNumber = $_POST['UserLogin']['contactNumber'];
            $model->emailId = $_POST['UserLogin']['emailId'];
            $model->roleId = $_POST['UserLogin']['roleId'];
            $model->address = $_POST['UserLogin']['address'];
            $model->username = $_POST['UserLogin']['username'];
            $model->is_active = $_POST['UserLogin']['is_active'];

            $roles = Role::findOne($_POST['UserLogin']['roleId']);
            if($roles){
                $model->role = $roles->role_name;
            }

            if($_FILES){
                if ($_FILES["UserLogin"]["error"]["profileImage"] == 0){
                    $file_name = preg_replace('/\s+/', '_', $_FILES['UserLogin']['name']['profileImage']);
                    $aa6 = "uploads/profileImage/user/" .$file_name;
                    move_uploaded_file($_FILES['UserLogin']['tmp_name']['profileImage'], $aa6);
                    $model->profileImage=$file_name; 
                }
            }

            $cy = RandomGeneration::find()->where(['key_id'=>'user'])->one();
            if($cy){
                $rt = $cy->random_number;
                $nmStr = substr($model->name, 0, 4);
                $cy->random_number = $cy->random_number+1;
                $cy->save();
                $reee = sprintf('%03u', $rt);
                $newCode = 'USR-'.$nmStr.'-'.$reee;
            }
            $model->userCode = $newCode;

            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->staff_name = $_POST['UserLogin']['name'];
            if($_POST['UserLogin']['password']!=""){
                $model->password = Yii::$app->security->generatePasswordHash($_POST['UserLogin']['password']);
            } 
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            $model->ip_address = $_SERVER['REMOTE_ADDR']; 
            if(!$model->save()){

            }else{
                Yii::$app->getSession()->setFlash('success', 'Admin user iformations Added'); 
            }


            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserLogin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            if(Yii::$app->request->isAjax){
                //$uniquemdel = new MerchantCategoryMasterUnique();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);  
            }
            // echo "<prE>";print_r($_FILES);die;
            $model->name = $_POST['UserLogin']['name'];
            $model->contactNumber = $_POST['UserLogin']['contactNumber'];
            $model->emailId = $_POST['UserLogin']['emailId'];
            $model->roleId = $_POST['UserLogin']['roleId'];
            $model->address = $_POST['UserLogin']['address'];
            $model->username = $_POST['UserLogin']['username'];
            $model->is_active = $_POST['UserLogin']['is_active'];
            $roles = Role::findOne($_POST['UserLogin']['roleId']);
            if($roles){
                $model->role = $roles->role_name;
            }
            // echo "<pre>";print_r($_FILES);die;
            if($_FILES){
                if ($_FILES["UserLogin"]["error"]["profileImage"] == 0){
                    $file_name = preg_replace('/\s+/', '_', $_FILES['UserLogin']['name']['profileImage']);
                    $aa6 = "uploads/profileImage/user/" .$file_name;
                    move_uploaded_file($_FILES['UserLogin']['tmp_name']['profileImage'], $aa6);
                    $model->profileImage=$file_name; 
                }
            }

            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->staff_name = $_POST['UserLogin']['name'];
            if($_POST['UserLogin']['password']!=""){
                $model->password = Yii::$app->security->generatePasswordHash($_POST['UserLogin']['password']);
            } 
            $model->updated_at = date('Y-m-d H:i:s');
            $model->ip_address = $_SERVER['REMOTE_ADDR']; 
            if(!$model->save()){
                // echo "<pre>";print_r($model->getErrors());die;
            }else{
                Yii::$app->getSession()->setFlash('success', 'Admin user iformations Updated');  
            }

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserLogin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $ar = array('0'=>'1','1'=>'0');
        if($model->is_active==""){
            $model->is_active = "1";
        }
        $model->is_active = $ar[$model->is_active];
        if($model->save()){
            if($model->is_active=="1"){
                $color = "success";
                $message = "Active";
            }else{
                $color = "danger";
                $message = "In-Active";
            }
            Yii::$app->getSession()->setFlash($color, 'Status updated as '.$message); 
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserLogin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserLogin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserLogin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
