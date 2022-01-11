<?php

namespace backend\controllers;

use Yii;
use backend\models\Role;
use backend\models\RoleManage;
use backend\models\RoleManageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleManageController implements the CRUD actions for RoleManage model.
 */
class RoleManageController extends Controller
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
     * Lists all RoleManage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleManageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RoleManage model.
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
     * Creates a new RoleManage model.
     * By Alban Bensam 18-12-2019
     * id Primary Key in Role
     * @param integer $id
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = (!empty($this->findModel($id))) ? $this->findModel($id) : new RoleManage();
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post()))
        {   
            if ($formTokenValue = Yii::$app->request->post('RoleManage')['hidden_Input']) 
            {   

                $sessionTokenValue =  $session['hidden_token'];
                if ($formTokenValue == $sessionTokenValue ) 
                {

                    // echo "<pre>";print_r($_POST);die;

                    $model->role_id =$id;
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

                    $role_service= json_encode((!empty(Yii::$app->request->post('RoleManage')['role_service'])) ? Yii::$app->request->post('RoleManage')['role_service'] : NULL);
                    
                     $model->role_service =($role_service == 'null') ? NULL : $role_service;

                    
                     
                        $model->role_rights = NULL;
                        $model->active_status = '1';
                        $model->ip_address=$_SERVER['REMOTE_ADDR'];
                        $model->system_name=gethostbyaddr($_SERVER['REMOTE_ADDR']);
                        $model->user_id=$session['user_id'];
                        $model->user_role=$session['user_type'];

                        $model->created_at=date('Y-m-d H:i:s');
                        $model->updated_at=date('Y-m-d H:i:s');

                       if($model->save())
                       {
                            Yii::$app->session->remove('hidden_token');

                            if(isset(Yii::$app->request->post('RoleManage')['update-franchise']) && Yii::$app->request->post('RoleManage')['update-franchise'] == 1)
                            {
                                RoleManage::updateAll(['role_service'=> $model->role_service,'role_rights'=>$model->role_rights,'updated_at'=>date('Y-m-d H:i:s')],['parent_id'=>$model->id]);
                            }
                            // Yii::$app->getSession()->setFlash('success', 'Role permissions Changed');  
                            return Yii::$app->response->redirect(['role-i']);
                       }
                       else
                       {
                            print_r($model->getErrors());die;
                       }
              }
              else
              { 
                    return Yii::$app->response->redirect(['role-i']); 
              }

            }
        }
        else
        {
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;

            return $this->render('_form', [
                'model' => $model,
                'id' => $id,
                'token_name' => $formTokenName
            ]);    
        }
        
    }

    /**
     * Updates an existing RoleManage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RoleManage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RoleManage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RoleManage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RoleManage::find()->where(['role_id'=>$id])->one()) !== null) {
            return $model;
        }
        else
        {
            return null;
        }
       // throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new RoleManage model.
     * By Alban Bensam 28-12-2019
     * id Primary Key in Role
     * @param integer $id
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionFranchiseCreate($id)
    {
        $model = (!empty($this->findModel($id))) ? $this->findModel($id) : new RoleManage();

        $session = Yii::$app->session;


        if ($model->load(Yii::$app->request->post()))
        {   

            if ($formTokenValue = Yii::$app->request->post('RoleManage')['hidden_Input']) 
            {   

              $sessionTokenValue =  $session['hidden_token'];
              
              if ($formTokenValue == $sessionTokenValue ) 
              {
               
                    $model->role_id =$id;
                    $role_service= json_encode((!empty(Yii::$app->request->post('RoleManage')['role_service'])) ? Yii::$app->request->post('RoleManage')['role_service'] : NULL);
                    
                     $model->role_service =($role_service == 'null') ? NULL : $role_service;

                    
                     
                        $model->role_rights = NULL;
                        $model->active_status = '1';
                        $model->ip_address=$_SERVER['REMOTE_ADDR'];
                        $model->system_name=gethostbyaddr($_SERVER['REMOTE_ADDR']);
                        $model->user_id=$session['user_id'];
                        $model->user_role=$session['user_type'];

                        $model->created_at=date('Y-m-d H:i:s');
                        $model->updated_at=date('Y-m-d H:i:s');

                       if($model->save())
                       {
                            Yii::$app->session->remove('hidden_token');

                            if(isset(Yii::$app->request->post('RoleManage')['update-franchise']) && Yii::$app->request->post('RoleManage')['update-franchise'] == 1)
                            {
                                RoleManage::updateAll(['role_service'=> $model->role_service,'role_rights'=>$model->role_rights,'updated_at'=>date('Y-m-d H:i:s')],['parent_id'=>$model->id]);
                            }


                            return Yii::$app->response->redirect(['franchise-role']);
                       }
                       else
                       {
                            print_r($model->getErrors());die;
                       }


              }
              else
              {
                  return Yii::$app->response->redirect(['franchise-role']); 
              }

            }
        }
        else
        {
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;

            return $this->render('_formfranchise', [
                'model' => $model,
                'id' => $id,
                'token_name' => $formTokenName
            ]);    
        }
        
    }
}
