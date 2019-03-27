<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\optativas\models\Docentexcomision;
use app\modules\optativas\models\Comision;
use app\models\Actividad;
use app\models\Docente;
use app\modules\optativas\models\DocentexcomisionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocentexcomisionController implements the CRUD actions for Docentexcomision model.
 */
class DocentexcomisionController extends Controller
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
     * Lists all Docentexcomision models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $searchModel = new DocentexcomisionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docentexcomision model.
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
     * Creates a new Docentexcomision model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       

        $comisionx = Yii::$app->request->queryParams['id'];
        $model = new Docentexcomision();
        $docentes = Docente::find()
                    ->orderBy('apellido, nombre')
                    ->all();

        $comisiones = Comision::find()
                    ->where(['id' => $comisionx])
                    ->all();

        $optativa = Actividad::find()
                    ->joinWith(['optativas', 'optativas.comisions'])
                    ->where(['comision.id' => $comisionx])
                    ->all();
        

        $model->comision = $comisionx;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/optativas/comision/view', 'id' => $comisionx]);
        }

        return $this->render('create', [
            'model' => $model,
            'docentes' => $docentes,
            'comisiones' => $comisiones,
            'optativa' => $optativa,
            
        ]);
    }

    /**
     * Updates an existing Docentexcomision model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
       
        $model = $this->findModel($id);
        $comisionx = Yii::$app->request->queryParams['id'];
        
        $docentes = Docente::find()
                    ->orderBy('apellido, nombre')
                    ->all();

        $comisiones = Comision::find()
                    ->where(['id' => $comisionx])
                    ->all();

        $optativa = Actividad::find()
                    ->joinWith(['optativas', 'optativas.comisions'])
                    ->where(['comision.id' => $comisionx])
                    ->all();

        //$model->comision = $comisionx;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'docentes' => $docentes,
            'comisiones' => $comisiones,
            'optativa' => $optativa,
            
        ]);
    }

    /**
     * Deletes an existing Docentexcomision model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       
        $comision = $this->findModel($id)->comision;
        $this->findModel($id)->delete();
        
        return $this->redirect(['comision/view' , 'id' => $comision]);
    }

    /**
     * Finds the Docentexcomision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Docentexcomision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Docentexcomision::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
