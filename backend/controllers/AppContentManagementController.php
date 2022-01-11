<?php

namespace backend\controllers;

use Yii;
use backend\models\AppContentManagement;
use backend\models\AppContentManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppContentManagementController implements the CRUD actions for AppContentManagement model.
 */
class AppContentManagementController extends Controller
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
     * Lists all AppContentManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppContentManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppContentManagement model.
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
     * Creates a new AppContentManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppContentManagement();

        if (Yii::$app->request->post()) {
            // echo "<prE>";print_r($_POST);die;

            if(array_key_exists('appName', $_POST)){
                $oldData = AppContentManagement::find()->where(['contentKey'=>'appName'])->one();
                if(!$oldData){
                    $oldData = new AppContentManagement();
                    $oldData->createdAt = date('Y-m-d H:i:s');
                }
                $oldData->contentKey = "appName";
                $oldData->contentValue = $_POST['appName'];
                $oldData->updatedAt = date('Y-m-d H:i:s');
                $oldData->save();
            }if(array_key_exists('appShortName', $_POST)){
                $oldData = AppContentManagement::find()->where(['contentKey'=>'appShortName'])->one();
                if(!$oldData){
                    $oldData = new AppContentManagement();
                    $oldData->createdAt = date('Y-m-d H:i:s');
                }
                $oldData->contentKey = "appShortName";
                $oldData->contentValue = $_POST['appShortName'];
                $oldData->updatedAt = date('Y-m-d H:i:s');
                $oldData->save();
            }if(array_key_exists('appFotter', $_POST)){
                $oldData = AppContentManagement::find()->where(['contentKey'=>'appFotter'])->one();
                if(!$oldData){
                    $oldData = new AppContentManagement();
                    $oldData->createdAt = date('Y-m-d H:i:s');
                }
                $oldData->contentKey = "appFotter";
                $oldData->contentValue = $_POST['appFotter'];
                $oldData->updatedAt = date('Y-m-d H:i:s');
                $oldData->save();
            }if(array_key_exists('appDescription', $_POST)){
                $oldData = AppContentManagement::find()->where(['contentKey'=>'appDescription'])->one();
                if(!$oldData){
                    $oldData = new AppContentManagement();
                    $oldData->createdAt = date('Y-m-d H:i:s');
                }
                $oldData->contentKey = "appDescription";
                $oldData->contentValue = $_POST['appDescription'];
                $oldData->updatedAt = date('Y-m-d H:i:s');
                $oldData->save();
            }if(array_key_exists('appVersion', $_POST)){
                $oldData = AppContentManagement::find()->where(['contentKey'=>'appVersion'])->one();
                if(!$oldData){
                    $oldData = new AppContentManagement();
                    $oldData->createdAt = date('Y-m-d H:i:s');
                }
                $oldData->contentKey = "appVersion";
                $oldData->contentValue = $_POST['appVersion'];
                $oldData->updatedAt = date('Y-m-d H:i:s');
                $oldData->save();
            }if(array_key_exists('contact', $_POST)){
                $oldData = AppContentManagement::find()->where(['contentKey'=>'contact'])->one();
                if(!$oldData){
                    $oldData = new AppContentManagement();
                    $oldData->createdAt = date('Y-m-d H:i:s');
                }
                $oldData->contentKey = "contact";
                $oldData->contentValue = $_POST['contact'];
                $oldData->updatedAt = date('Y-m-d H:i:s');
                $oldData->save();
            }if(array_key_exists('email', $_POST)){
                $oldData = AppContentManagement::find()->where(['contentKey'=>'email'])->one();
                if(!$oldData){
                    $oldData = new AppContentManagement();
                    $oldData->createdAt = date('Y-m-d H:i:s');
                }
                $oldData->contentKey = "email";
                $oldData->contentValue = $_POST['email'];
                $oldData->updatedAt = date('Y-m-d H:i:s');
                $oldData->save();
            }if(array_key_exists('developedBy', $_POST)){
                $oldData = AppContentManagement::find()->where(['contentKey'=>'developedBy'])->one();
                if(!$oldData){
                    $oldData = new AppContentManagement();
                    $oldData->createdAt = date('Y-m-d H:i:s');
                }
                $oldData->contentKey = "developedBy";
                $oldData->contentValue = $_POST['developedBy'];
                $oldData->updatedAt = date('Y-m-d H:i:s');
                $oldData->save();
            }if(array_key_exists('website', $_POST)){
                $oldData = AppContentManagement::find()->where(['contentKey'=>'website'])->one();
                if(!$oldData){
                    $oldData = new AppContentManagement();
                    $oldData->createdAt = date('Y-m-d H:i:s');
                }
                $oldData->contentKey = "website";
                $oldData->contentValue = $_POST['website'];
                $oldData->updatedAt = date('Y-m-d H:i:s');
                $oldData->save();
            }
            return $this->redirect(['create']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AppContentManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->autoId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AppContentManagement model.
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
     * Finds the AppContentManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppContentManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppContentManagement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
