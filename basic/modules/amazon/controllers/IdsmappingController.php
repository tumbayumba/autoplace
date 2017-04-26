<?php

namespace app\modules\amazon\controllers;

use Yii;
use app\modules\amazon\models\IdsMapping;
use app\modules\amazon\models\IdsMappingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * IdsmappingController implements the CRUD actions for IdsMapping model.
 */
class IdsmappingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all IdsMapping models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IdsMappingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IdsMapping model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new IdsMapping model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IdsMapping();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing IdsMapping model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing IdsMapping model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the IdsMapping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return IdsMapping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IdsMapping::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //SET PRODUCT_ID FOR ALL HOSTS WITHOUT SKU AND ASIN
    public function actionSetproductids()
    {
        $ids_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'product_ids.csv';
        $ids = [];
        $ids_handle = fopen($ids_file,"r");
        while(($buffer=fgetcsv($ids_handle,"1000",",")))
            if($buffer[0]!='')
                $ids[$buffer[0]] = $buffer[0];
        fclose($ids_handle);
        $sql = 'INSERT INTO tbl_ids_mapping(product_id,host_id) VALUES ';
        for($i=3;$i<6;$i++){
            foreach($ids as $product_id){
                $sql .= '('.$product_id.','.$i.'),';
            }
        }
        $sql = rtrim($sql,",");
        //Yii::$app->db1->createCommand($sql)->queryAll();
    }
}
