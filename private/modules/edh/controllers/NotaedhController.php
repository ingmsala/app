<?php

namespace app\modules\edh\controllers;

use app\models\Trimestral;
use app\modules\edh\models\Detalleplancursado;
use Yii;
use app\modules\edh\models\Notaedh;
use app\modules\edh\models\NotaedhSearch;
use app\modules\edh\models\Tiponotaedh;
use kartik\form\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * NotaedhController implements the CRUD actions for Notaedh model.
 */
class NotaedhController extends Controller
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
     * Lists all Notaedh models.
     * @return mixed
     */
    public function actionIndex($det)
    {
        $searchModel = new NotaedhSearch();
        $dataProvider = $searchModel->porDetalle($det);

        $materia = Detalleplancursado::findOne($det)->catedra0->actividad0->nombre;

        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'det' => $det,
            'materia' => $materia,
        ]);
    }

    public function actionViewlegajo($det)
    {
        //$searchModel = new NotaedhSearch();
        //$dataProvider = $searchModel->porDetalle($det);

        $notas = Notaedh::find()->where(['detalleplancursado' => $det])->all();

        $materia = Detalleplancursado::findOne($det)->catedra0->actividad0->nombre;

        $arr = [];
        $str1t = '';
        $str2t = '';
        $str3t = '';
        

        foreach ($notas as $nota) {
            if($nota->trimestre == 1){
                if($nota->tiponota == 1){
                    $arr[0][1][] = $nota->nota;
                    $str1t .=  $nota->nota.' - ';
                }else{
                    $arr[0][3]=$nota->nota;
                }
            }elseif($nota->trimestre == 2){
                if($nota->tiponota == 1){
                    $arr[0][5][] = $nota->nota;
                    $str2t .=  $nota->nota.' - ';
                }else{
                    $arr[0][7]=$nota->nota;
                }
            }else{
                if($nota->tiponota == 1){
                    $arr[0][9][] = $nota->nota;
                    $str3t .=  $nota->nota.' - ';
                }else{
                    $arr[0][11]=$nota->nota;
                }

            }
        }

        try {
            $arr[0][2] = (float)bcdiv(array_sum($arr[0][1])/count($arr[0][1]), '1', 1);
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            if(isset($arr[0][2])){
                $arr[0][4] = round(($arr[0][2]+$arr[0][3])/2,1);
            }else{
                $arr[0][4] = round($arr[0][3],1);
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $arr[0][6] = (float)bcdiv(array_sum($arr[0][5])/count($arr[0][5]), '1', 1);
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            if(isset($arr[0][6])){
                $arr[0][8] = round(($arr[0][6]+$arr[0][7])/2,1);
            }else{
                $arr[0][8] = round($arr[0][7],1);
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $arr[0][10] = (float)bcdiv(array_sum($arr[0][9])/count($arr[0][9]), '1', 1);
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            if(isset($arr[0][10])){
                $arr[0][12] = round(($arr[0][10]+$arr[0][11])/2,1);
            }else{
                $arr[0][12] = round($arr[0][11],1);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        try {
            $arr[0][1] = $str1t;
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $arr[0][5] = $str2t;
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $arr[0][9] = $str3t;
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {
            $sumtot = $arr[0][4]+$arr[0][8]+$arr[0][12];
            if($sumtot>=21)
                $arr[0][13] = round($sumtot/3,0);
            else
                $arr[0][13] = intval($sumtot/3);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        

        
        

        $dataProvider = new ArrayDataProvider([
            'allModels' => $arr,
            
        ]);

        //return var_dump($dataProvider);

        return $this->renderAjax('viewlegajo', [
            
            'dataProvider' => $dataProvider,
            'det' => $det,
            'materia' => $materia,
        ]);
    }

    /**
     * Displays a single Notaedh model.
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
     * Creates a new Notaedh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($det)
    {
        $model = new Notaedh();
        $model->detalleplancursado = $det;
        $tiposnota = Tiponotaedh::find()->all();
        $trimestres = Trimestral::find()->where(['<', 'id', 4])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se creó la calificación correctamente');
            return $this->redirect(['plancursado/view', 'id' => $model->detalleplancursado0->plan, 'ref' => $model->detalleplancursado]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'tiposnota' => $tiposnota,
            'trimestres' => $trimestres,
        ]);
    }

    /**
     * Updates an existing Notaedh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tiposnota = Tiponotaedh::find()->all();
        $trimestres = Trimestral::find()->where(['<', 'id', 4])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se modificó la calificación correctamente');
            return $this->redirect(['plancursado/view', 'id' => $model->detalleplancursado0->plan, 'ref' => $model->detalleplancursado]);
        
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'tiposnota' => $tiposnota,
            'trimestres' => $trimestres,
        ]);
    }

    /**
     * Deletes an existing Notaedh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $detallecursado = $model->detalleplancursado0;
        $model->delete();

        Yii::$app->session->setFlash('success', 'Se modificó la calificación correctamente');
        return $this->redirect(['plancursado/view', 'id' => $detallecursado->plan, 'ref' => $detallecursado->id]);
    }

    /**
     * Finds the Notaedh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notaedh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notaedh::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
