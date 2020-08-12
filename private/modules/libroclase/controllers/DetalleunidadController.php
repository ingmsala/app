<?php

namespace app\modules\libroclase\controllers;

use Yii;
use app\modules\libroclase\models\Detalleunidad;
use app\modules\libroclase\models\DetalleunidadSearch;
use app\modules\libroclase\models\Unidad;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DetalleunidadController implements the CRUD actions for Detalleunidad model.
 */
class DetalleunidadController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Detalleunidad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetalleunidadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Detalleunidad model.
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
     * Creates a new Detalleunidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($programa)
    {
        $model = new Detalleunidad();
        $model->programa = $programa;

        $unidadesdelprograma = Detalleunidad::find()->select(['unidad'])->where(['programa' => $programa])->all();

        
        
        $unidades = Unidad::find()->where(['not in', 'id', array_column($unidadesdelprograma,'unidad')])->all();

        if ($model->load(Yii::$app->request->post())) {

            $param = Yii::$app->request->post();

            
            foreach ($param['Detalleunidad']['unidad'] as $unidad) {
                $model2 = new Detalleunidad();
                $model2->programa = $programa;
                $model2->unidad = $unidad;
                if(count($param['Detalleunidad']['unidad'])==1){
                    $model2->nombre = $param['Detalleunidad']['nombre'];
                    //return var_dump($param);
                }
                $model2->save();
                
            }
            
            return $this->redirect(['/libroclase/programa/view', 'id' => $programa, 'in' => $model2->id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'unidades' => $unidades,
        ]);
    }

    /**
     * Updates an existing Detalleunidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$programa = $model->programa;
        //$unidadesdelprograma = Detalleunidad::find()->select(['unidad'])->where(['programa' => $programa])->all();
    
        $unidades = Unidad::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/libroclase/programa/view', 'id' => $model->programa, 'in' => $model->id]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'unidades' => $unidades,
        ]);
    }

    /**
     * Deletes an existing Detalleunidad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $programa = $model->programa;
        $model->delete();
        return $this->redirect(['/libroclase/programa/view', 'id' => $programa]);
        
    }

    /**
     * Finds the Detalleunidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detalleunidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detalleunidad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
