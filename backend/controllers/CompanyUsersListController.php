<?php

namespace backend\controllers;

use Yii;
use backend\models\CompanyUsersList;
use backend\models\CompanyUsersListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyUsersListController implements the CRUD actions for CompanyUsersList model.
 */
class CompanyUsersListController extends Controller
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
     * Lists all CompanyUsersList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanyUsersListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyUsersList model.
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
     * Creates a new CompanyUsersList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompanyUsersList();

        if ($model->load(Yii::$app->request->post())) {
            $model->name = ucfirst($_POST['CompanyUsersList']['name']);
            $model->deliveryFrequency = json_encode($_POST['deliveryFrequency']);

            $toastIcon = "fa fa-close";
            $toastMesg = "Failerd to update User info.!";
            $isSuccess = "failure";
            if($model->save()){
                $isSuccess = "success";
                $toastIcon = "fa fa-check";
                $toastMesg = "Company user informations added.!";
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
     * Updates an existing CompanyUsersList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->name = ucfirst($_POST['CompanyUsersList']['name']);
            $model->deliveryFrequency = json_encode($_POST['deliveryFrequency']);

            $toastIcon = "fa fa-close";
            $toastMesg = "Failerd to update User info.!";
            $isSuccess = "failure";
            if($model->save()){
                $isSuccess = "success";
                $toastIcon = "fa fa-check";
                $toastMesg = "Company user informations updated.!";
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
     * Deletes an existing CompanyUsersList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $ar = array('I'=>'A','A'=>'I');
        if($model->status==""){
            $model->status = "A";
        }
        $model->status = $ar[$model->status];
        $toastIcon = "fa fa-close";
        $toastMesg = "Failerd to update user's status.!";
        $isSuccess = "failure";       
       
        if($model->save()){
            if($model->status=="A"){
                $isSuccess = "success";
                $toastIcon = "fa fa-check-circle-o";
                $toastMesg = "User Activated.!";
                $color = "success";
                $message = "Active";
            }else{

                $isSuccess = "success";
                $toastIcon = "fa fa-ban";
                $toastMesg = "User In-Activated.!";
                $color = "danger";
                $message = "In-Active";
            }
        }

        $session = Yii::$app->session;
        $session['toastIcon'] = $toastIcon;
        $session['toastMessage'] = $toastMesg;
        $session['isToastSuccess'] = $isSuccess;
        $session['isToast'] = "yes";

        return $this->redirect(['index']);
    }

    /**
     * Finds the CompanyUsersList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyUsersList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompanyUsersList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
