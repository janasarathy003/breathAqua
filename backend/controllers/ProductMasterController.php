<?php

namespace backend\controllers;

use Yii;
use backend\models\BrandMaster;
use backend\models\CapacityMaster;
use backend\models\ProductMaster;
use backend\models\ProductMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductMasterController implements the CRUD actions for ProductMaster model.
 */
class ProductMasterController extends Controller
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
     * Lists all ProductMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductMaster model.
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
     * Creates a new ProductMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductMaster();

        if ($model->load(Yii::$app->request->post())) {
            $brandMs = BrandMaster::findOne($_POST['ProductMaster']['brandId']);
            if($brandMs){
                $model->brandName = $brandMs->brandName;
            }
            $capacityMs = CapacityMaster::findOne($_POST['ProductMaster']['capacityId']);
            if($capacityMs){
                $model->capacity = $capacityMs->capacityName;
            }
            $toastIcon = "fa fa-close";
            $toastMesg = "Failerd to add new product.!";
            $isSuccess = "failure";
            if($model->save()){
                $isSuccess = "success";
                $toastIcon = "fa fa-check";
                $toastMesg = "New product added.!";
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
     * Updates an existing ProductMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $brandMs = BrandMaster::findOne($_POST['ProductMaster']['brandId']);
            if($brandMs){
                $model->brandName = $brandMs->brandName;
            }
            $capacityMs = CapacityMaster::findOne($_POST['ProductMaster']['capacityId']);
            if($capacityMs){
                $model->capacity = $capacityMs->capacityName;
            }
            $toastIcon = "fa fa-close";
            $toastMesg = "Failerd to update product informations.!";
            $isSuccess = "failure";
            if($model->save()){
                $isSuccess = "success";
                $toastIcon = "fa fa-check";
                $toastMesg = "product updated.!";
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
     * Deletes an existing ProductMaster model.
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
     * Finds the ProductMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
