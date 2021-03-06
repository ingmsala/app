<?php

namespace app\controllers;

use Yii;
use app\models\Actividad;
use app\models\ActividadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Plan;
use app\models\Actividadtipo;
use app\models\Propuesta;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Departamento;
use app\models\Division;
use yii\helpers\ArrayHelper;
/**
 * ActividadController implements the CRUD actions for Actividad model.
 */
class ActividadController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete','xpropuesta'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['xpropuesta'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                           try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

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
     * Lists all Actividad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActividadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Actividad model.
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
     * Creates a new Actividad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Actividad();
        $planes=Plan::find()->all();
        $actividadtipos=Actividadtipo::find()->all();
        $propuestas=Propuesta::find()->all();
        $departamentos = Departamento::find()->orderBy('nombre')->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'planes' => $planes,
            'actividadtipos' => $actividadtipos,
            'propuestas' => $propuestas,
            'departamentos' => $departamentos,

        ]);
    }

    /**
     * Updates an existing Actividad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $planes=Plan::find()->all();
        $actividadtipos=Actividadtipo::find()->all();
        $propuestas=Propuesta::find()->all();
        $departamentos = Departamento::find()->orderBy('nombre')->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'planes' => $planes,
            'actividadtipos' => $actividadtipos,
            'propuestas' => $propuestas,
            'departamentos' => $departamentos,
        ]);
    }

    /**
     * Deletes an existing Actividad model.
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
     * Finds the Actividad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Actividad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Actividad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
    public function actionXpropuesta()
    {   
        $searchModel = new ActividadSearch();
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $propuesta_id = $parents[0];
                $actividad = Actividad::find()
                ->where(['propuesta' => $propuesta_id])
                ->orderBy('nombre ASC')
                ->all();
                

                $listActividad=ArrayHelper::toArray($actividad, [
                    'app\models\Actividad' => [
                        'id',
                        'name' => function($model){
                            try {
                                return $model->nombre.' (Plan: '.$model->plan0->nombre.')';
                            } catch (\Throwable $th) {
                                return $model->nombre;
                            }
                            
                        },
                    ],
                ]);
                $out = $listActividad;
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];
        
                
        
    }

    public function actionXplan()
    {   
        $searchModel = new ActividadSearch();
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $division = $parents[0];

                $div = Division::findOne($division);
                $div = $div->nombre[0];

                if($div<=4)
                    $plan_id = 2;
                else    
                    $plan_id = 1;

                $div2019 = $div-2;

                $actividad = Actividad::find()
                ->where(['plan' => $plan_id])
                ->andWhere(['propuesta' => 1])
                ->andWhere(['actividadtipo' => 1])
                ->andWhere(['<=', 'curso', $div2019])
                ->orderBy('curso, nombre')
                ->all();
                

                $listActividad=ArrayHelper::toArray($actividad, [
                    'app\models\Actividad' => [
                        'id',
                        'name' => function($model){
                            return $model->curso.'° - '.$model->nombre;
                        },
                    ],
                ]);
                $out = $listActividad;
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];
        
                
        
    }
}
