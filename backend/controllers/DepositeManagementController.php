<?php

namespace backend\controllers;

use Yii;
use backend\models\DepositeManagement;
use backend\models\DepositeManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DepositeManagementController implements the CRUD actions for DepositeManagement model.
 */
class DepositeManagementController extends Controller
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
     * Lists all DepositeManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DepositeManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DepositeManagement model.
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
     * Creates a new DepositeManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DepositeManagement();
        if ($model->load(Yii::$app->request->post())) {
            // echo "<pre>";print_r($_POST);die;

            $toastIcon = "fa fa-close";
            $toastMesg = "Failerd to add deposite.!";
            $isSuccess = "failure";
            if($model->save()){
                $isSuccess = "success";
                $toastIcon = "fa fa-check";
                $toastMesg = "Deposite details added.!";
            }
            $session = Yii::$app->session;
            $session['toastIcon'] = $toastIcon;
            $session['toastMessage'] = $toastMesg;
            $session['isToastSuccess'] = $isSuccess;
            $session['isToast'] = "yes";
            return $this->redirect(['index']);
        }
        

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DepositeManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // echo "<pre>";print_r($_POST);die;

            $toastIcon = "fa fa-close";
            $toastMesg = "Failerd to add deposite.!";
            $isSuccess = "failure";
            if($model->save()){
                $isSuccess = "success";
                $toastIcon = "fa fa-check";
                $toastMesg = "Deposite details updated.!";
            }
            $session = Yii::$app->session;
            $session['toastIcon'] = $toastIcon;
            $session['toastMessage'] = $toastMesg;
            $session['isToastSuccess'] = $isSuccess;
            $session['isToast'] = "yes";
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DepositeManagement model.
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
     * Finds the DepositeManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DepositeManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DepositeManagement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
