<?php

namespace app\modules\libroclase\controllers;

use Yii;
use app\modules\libroclase\models\Temaunidad;
use app\modules\libroclase\models\TemaunidadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TemaunidadController implements the CRUD actions for Temaunidad model.
 */
class TemaunidadController extends Controller
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
     * Lists all Temaunidad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemaunidadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Temaunidad model.
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
     * Creates a new Temaunidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($detalleunidad)
    {
        
        $model = new Temaunidad();
        $model->detalleunidad = $detalleunidad;

        if ($model->load(Yii::$app->request->post())) {
            $cantidad = Temaunidad::find()->where(['detalleunidad' => $detalleunidad])->count()+1;
            $param = Yii::$app->request->post();

            $temas = $param['Temaunidad']['descripcion'];
            $separador = $param['separador'];
            $procesar = $param['procesar'];

            if($separador == ''){
                //return var_dump($separador);
                $model->prioridad = $cantidad;
                $model->save();
            }else{

                try {
                    $temas2 = explode($separador, $procesar);
                    $i = 0;
                    foreach ($temas2 as $t) {
                        $model2 = new Temaunidad();
                        $model2->prioridad = $cantidad + $i;
                        $model2->detalleunidad = $detalleunidad;
                        $model2->descripcion = $t;
                        $model2->save();
                        $i++;
                    }
                } catch (\Throwable $th) {
                    //$model->descripcion = $param['Temaunidad']['descripcion'];
                    $model->prioridad = $cantidad;
                    $model->save();
                }
            }

            //return var_dump($param);
            
            

            

            //return var_dump($param);

            return $this->redirect(['/libroclase/programa/view', 'id' => $model->detalleunidad0->programa, 'in' => $model->detalleunidad0->id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Temaunidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/libroclase/programa/view', 'id' => $model->detalleunidad0->programa, 'in' => $model->detalleunidad0->id]);
        }


        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Temaunidad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $modelaux = $this->findModel($id);
        $model = $modelaux;
        $modelaux->delete();

        $temas = Temaunidad::find()
            ->where(['detalleunidad' => $model->detalleunidad])
            ->andWhere((['>', 'prioridad', $model->prioridad]))
            ->all();
        
        foreach ($temas as $tema) {
            $tema->prioridad = $tema->prioridad - 1;
            $tema->save();
        }

        return $this->redirect(['/libroclase/programa/view', 'id' => $model->detalleunidad0->programa, 'in' => $model->detalleunidad0->id]);
        
        
    }

    public function actionCambiarprioridad($up, $id){

        $modelaux = $this->findModel($id);
        if($up == 1){
            $modelacambiar = Temaunidad::find()
            ->where(['detalleunidad' => $modelaux->detalleunidad])
            ->andWhere((['=', 'prioridad', ($modelaux->prioridad - 1)]))
            ->one();
            if($modelacambiar != null){
                $modelacambiar->prioridad = $modelaux->prioridad;
                $modelaux->prioridad = $modelaux->prioridad - 1;
                $modelacambiar->save();
                $modelaux->save();
            }
            

        }else{
            $modelacambiar = Temaunidad::find()
            ->where(['detalleunidad' => $modelaux->detalleunidad])
            ->andWhere((['=', 'prioridad', ($modelaux->prioridad + 1)]))
            ->one();
            if($modelacambiar != null){
                $modelacambiar->prioridad = $modelaux->prioridad;
                $modelaux->prioridad = $modelaux->prioridad + 1;
                $modelacambiar->save();
                $modelaux->save();
            }
            
        }

        return $modelaux->detalleunidad0->id;

        //return $this->redirect(['/libroclase/programa/view', 'id' => $modelaux->detalleunidad0->programa, 'in' => $modelaux->detalleunidad0->id]);
        

    }

    /**
     * Finds the Temaunidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Temaunidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Temaunidad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
