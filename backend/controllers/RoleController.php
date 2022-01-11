<?php

namespace backend\controllers;

use Yii;
use backend\models\Role;
use backend\models\RoleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UserActivityLog;
/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
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
                    'role-d' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
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
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) 
        {
            if(Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            $Role=Yii::$app->request->post('Role');
            $model->role_name = $Role['role_name'];
            $model->role_description = (!empty($Role['role_description'])) ? $Role['role_description'] : NULL;
            
            $model->role_type = ($session['master_type'] == 'F') ?  'F' : 'D' ;
            $model->ref_id = ($session['master_type'] == 'F') ?  $session['branch_id'] : NULL ;

            $model->ip_address=$_SERVER['REMOTE_ADDR'];
            $model->system_name=gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $model->user_id=$session['user_id'];
            $model->user_role=$session['user_type'];
            
            if(!empty($Role['active_status']))
            {
                if($Role['active_status'] == 'on')
                {
                    $model->active_status='1';    
                }    
            }
            else
            {
                $model->active_status='0';       
            }
            $model->user_type='D'; 
            $model->created_at=date('Y-m-d H:i:s');
            $model->updated_at=date('Y-m-d H:i:s');
            if($model->save())
            {
                Yii::$app->getSession()->setFlash('success', 'Role Informations Added');
                return $this->reDirect(['index']); 
            }else{
                Yii::$app->getSession()->setFlash('danger', 'Role Informations not Added');
                return $this->reDirect(['index']);
            }
        }
        else
        {
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            return Yii::$app->controller->render('_form', ['model' => $model,
                'token_name' => $formTokenName], true, false);    
        }
        
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post())) 
        {

            if(Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $Role=Yii::$app->request->post('Role');
            $model->role_name = $Role['role_name'];
            $model->role_description = (!empty($Role['role_description'])) ? $Role['role_description'] : NULL;
            $model->role_type = 'D';
            $model->ip_address=$_SERVER['REMOTE_ADDR'];
            $model->system_name=gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $model->user_id=$session['user_id'];
            $model->user_role=$session['user_type'];
            if(!empty($Role['active_status']))
            {
                if($Role['active_status'] == 'on')
                {
                    $model->active_status='1';
                }
            }
            else
            {
                $model->active_status='0';
            }
            $model->user_type='D'; 
            $model->updated_at=date('Y-m-d H:i:s');
            if($model->save())
            {
                Yii::$app->getSession()->setFlash('success', 'Role Informations Changed');  
                return $this->reDirect(['index']);   
            }else{
                Yii::$app->getSession()->setFlash('success', 'Role Informations Changed');
                return $this->reDirect(['index']);
            }
        }
        else
        {
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            return Yii::$app->controller->render('_form', ['model' => $model,
                'token_name' => $formTokenName], true, false);    
        }
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $ar = array('0'=>'1','1'=>'0');
        if($model->active_status==""){
            $model->active_status = "1";
        }
        $model->active_status = $ar[$model->active_status];
        if($model->save()){
            if($model->active_status=="1"){
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
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionManageindex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->managesearch(Yii::$app->request->queryParams);

        return $this->render('manageindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionFranchiseRole()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->searchfranchise(Yii::$app->request->queryParams);
        return $this->render('franchiseindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRoleManage($id)
    {
        $model = (!empty($this->findModel($id))) ? $this->findModel($id) : new RoleManage();

        $session = Yii::$app->session;


        if ($model->load(Yii::$app->request->post()))
        {   

                
                // echo "<pre>";print_r($_POST);die;
                // echo "<pre>";print_r($model);die;

                    // $model->role_id =$id;
                    $resAr = array();
                    if(!empty($_POST)){
                        if(array_key_exists('cateIds', $_POST)){
                            $resAr['menu'] = $_POST['cateIds'];
                        }
                        if(array_key_exists('subcateIds', $_POST)){
                            $resAr['submenu'] = $_POST['subcateIds'];
                        }
                    }

                    $roleModel = Role::findOne($id);
                    if($roleModel){
                        $roleModel->permissions = json_encode($resAr);
                        if(!$roleModel->save()){
                            echo "<pre>";print_r($roleModel->getErrors());die;
                        }
                    }

                    $model->permissions = json_encode($resAr);

                       if($model->save())
                       {
                            


                            return $this->reDirect(['index']);  
                       }
                       else
                       {
                            print_r($model->getErrors());die;
                       }
             
        }
        else
        {
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;

            return $this->render('_formRole', [
                'model' => $model,
                'id' => $id,
                'token_name' => $formTokenName
            ]);    
        }
        
    }

}
