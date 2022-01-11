<?php

namespace backend\controllers;

use Yii;
use backend\models\RandomGeneration;
use backend\models\OrderManagement;
use backend\models\OrderManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderManagementController implements the CRUD actions for OrderManagement model.
 */
class OrderManagementController extends Controller
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
     * Lists all OrderManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderManagement model.
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
     * Creates a new OrderManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderManagement();

        if ($model->load(Yii::$app->request->post())) {

            $code = "";
            $cy = RandomGeneration::find()->where(['key_id'=>'order'])->one();
            if($cy){
                $rt = $cy->random_number;
                $cy->random_number = $cy->random_number+1;
                if(!$cy->save()){
                    echo "<prE>";print_r($cy->getErrors());die;
                }
                $reee = sprintf('%03u', $rt);
                $code = 'ORDER-'.$reee;
            }

            $model->orderCode = $code;
            $model->status = "orderPlaced";

            $toastIcon = "fa fa-close";
            $toastMesg = "Failerd to create order.!";
            $isSuccess = "failure";
            if($model->save()){
                $isSuccess = "success";
                $toastIcon = "fa fa-check";
                $toastMesg = "Order placed.!";
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
     * Updates an existing OrderManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->orderCode = $code;
            $toastIcon = "fa fa-close";
            $toastMesg = "Failerd to create order.!";
            $isSuccess = "failure";
            if($model->save()){
                $isSuccess = "success";
                $toastIcon = "fa fa-check";
                $toastMesg = "Order placed.!";
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
     * Deletes an existing OrderManagement model.
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
     * Finds the OrderManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderManagement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
