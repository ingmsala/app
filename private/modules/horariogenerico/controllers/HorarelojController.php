<?php

namespace app\modules\horariogenerico\controllers;

use app\models\Semana;
use app\modules\horariogenerico\models\Burbuja;
use Yii;
use app\modules\horariogenerico\models\Horareloj;
use app\modules\horariogenerico\models\HorarelojSearch;
use app\modules\horariogenerico\models\Horariogeneric;
use kartik\grid\EditableColumnAction;
use kartik\select2\Select2;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * HorarelojController implements the CRUD actions for Horareloj model.
 */
class HorarelojController extends Controller
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

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editinicio' => [                                       
                'class' => EditableColumnAction::className(),     
                'modelClass' => Horareloj::className(),                
                'outputValue' => function ($model, $attribute, $key, $index) {
                     //$fmt = Yii::$app->formatter;
                     return $model->$attribute;                 
                },
                'outputMessage' => function($model, $attribute, $key, $index) {
                      return '';                                  
                },
                
            ]
        ]);
    }

    /**
     * Lists all Horareloj models.
     * @return mixed
     */
    public function actionPorsemana($semana, $turno, $anio)
    {
        $searchModel = new HorarelojSearch();
        $dataProvider = $searchModel->porsemana($semana, $turno, $anio);
        
        Horariogeneric::find()
                ->joinWith(['catedra0', 'catedra0.division0'])
                ->where(['semana' => $semana])
                ->andWhere(['LEFT(division.nombre, 1)' => $anio])
                ->andWhere(['division.turno' => $turno])
                ->all();

        $fechas = $this->getFechasyburbujas($semana, $turno, $anio);


        if (Yii::$app->request->post()) {

            //return $this->redirect(['view', 'burtodos' => Yii::$app->request->post(), $semana]);
            
            $params2 = Yii::$app->request->post();
            $expl2 = explode('*', $params2['btn_submit']);
            $semana2 = $expl2[0];
            $anio2 = $expl2[1];
            $turno2 = $expl2[2];
            $fecha2 = $expl2[3];
            $burbuja2 = $params2[$fecha2];

            if($burbuja2 != ''){
                $horarios2 = Horariogeneric::find()
                            ->joinWith(['catedra0', 'catedra0.division0'])
                            ->where(['semana' => $semana2])
                            ->andWhere(['LEFT(division.nombre, 1)' => $anio2])
                            ->andWhere(['division.turno' => $turno2])
                            ->andWhere(['horariogeneric.fecha' => $fecha2])
                            ->all();
            
                foreach ($horarios2 as $horario2) {
                    $horario2->burbuja = $burbuja2;
                    $horario2->save();
                }
            }
            return $this->redirect(['/semana/view', 'id' => $semana2, 'anio' => $anio2, 'turno' =>$turno2]);
           

        }


        return $this->renderAjax('_porsemana', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

            'anio' => $anio,
            'turno' => $turno,
            'semana' => $semana,

            'fechas' => $fechas,
        ]);
    }

    /**
     * Displays a single Horareloj model.
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

    protected function getFechasyburbujas($semana, $turno, $anio){
        /*Dias de la semana*/
        $model = Semana::findOne($semana);
        $start = $model->inicio;
        $end = $model->fin;

        $fechas = [];

        $dias2 = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

        if (is_string($start) === true) $start = strtotime($start);
        if (is_string($end) === true ) $end = strtotime($end);
        do {
            
            
            $horarios = Horariogeneric::find()
            ->joinWith(['catedra0', 'catedra0.division0'])
            ->where(['semana' => $semana])
            ->andWhere(['LEFT(division.nombre, 1)' => $anio])
            ->andWhere(['turno' => $turno])
            ->andWhere(['fecha' => date('Y-m-d', $start)])
            ->all();
            if(count($horarios)>0){
                $fechas[date('Y-m-d', $start)]['fecha'] = $dias2[(date('w', $start)-1)].' '.date('d/m', $start);

            $burbujas = ArrayHelper::map($horarios, 'burbuja', function($model){
                try {
                    return $model->burbuja;
                } catch (\Throwable $th) {
                    return '';
                }
                
            });

            $burbujascombo = Burbuja::find()->all();
            $burbujascombo = ArrayHelper::map($burbujascombo, 'id', 'nombre');

            $bur = '';

            if(count($burbujas)==0){
                $fechas[date('Y-m-d', $start)]['burbuja'] = 'Sin definir';
            }elseif(count($burbujas)==1){
                foreach ($burbujas as $burbuja) {
                    $bur = $burbuja;
                    break;
                }
                if($bur == '')
                    $bur = 'Sin definir';
                try {
                    $fechas[date('Y-m-d', $start)]['burbuja'] = Burbuja::findOne($bur)->nombre;
                } catch (\Throwable $th) {
                    $fechas[date('Y-m-d', $start)]['burbuja'] = $bur;
                }
                
            }else{
                $fechas[date('Y-m-d', $start)]['burbuja'] = 'Personalizada';
            }


            $fechas[date('Y-m-d', $start)]['cambiar'] = '<span class="col-md-6">'.Select2::widget([
                'name' => date('Y-m-d', $start),
                'data' => $burbujascombo,
                'value' => $bur,
                'options' => [
                    'placeholder' => 'Seleccionar',
                    
                ],
            ]).'</span><span class="col-md-6">'.Html::submitButton('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', ['class' => 'btn btn-primary', "name" => "btn_submit", "value" => $semana.'*'.$anio.'*'.$turno.'*'.date('Y-m-d', $start)]).'</span>';

            }
            
            $start = strtotime("+ 1 day", $start);


        } while($start <= $end);

        //return var_dump($fechas);
        $fechas = new ArrayDataProvider([
            'allModels' => $fechas,
            
        ]);

        return $fechas;
    }

    /**
     * Creates a new Horareloj model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Horareloj();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Horareloj model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/semana/view', 'id' => $model->semana, 'anio' => $model->anio, 'turno' =>$model->turno]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Horareloj model.
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
     * Finds the Horareloj model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Horareloj the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Horareloj::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
