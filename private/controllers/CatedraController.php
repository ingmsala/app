<?php

namespace app\controllers;

use Yii;
use app\models\Catedra;
use app\models\CatedraSearch;
use app\models\Actividad;
use app\models\Division;
use app\models\Propuesta;
use app\models\Docente;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Detallecatedra;
use app\models\DetallecatedraSearch;
use yii\filters\AccessControl;
use app\config\Globales;

/**
 * CatedraController implements the CRUD actions for Catedra model.
 */
class CatedraController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update'],   
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
                        'actions' => ['delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_CONSULTA]);
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
     * Lists all Catedra models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->session->remove('urlorigen');
        $param = Yii::$app->request->queryParams;
        $model = new Catedra();
        $model->scenario = $model::SCENARIO_SEARCHINDEX;
        $searchModel = new CatedraSearch();
        $dataProvider = $searchModel->providercatedras($param);
        $divisiones = Division::find()->all();
        $propuestasall = Propuesta::find()->all();
        $resoluciones = Detallecatedra::find()
                    ->select('resolucion')->distinct()->all();

        $docentes = Docente::find()
                        ->orderBy('apellido')
                        ->all();
        if(isset($param['Catedra']['propuesta']))
            $model->propuesta = $param['Catedra']['propuesta'];
        if(isset($param['Catedra']['docente']))
            $model->docente = $param['Catedra']['docente'];
        if(isset($param['Catedra']['actividadnom']))
            $model->actividadnom = $param['Catedra']['actividadnom'];
        if(isset($param['Catedra']['divisionnom']))
            $model->divisionnom = $param['Catedra']['divisionnom'];
        if(isset($param['Catedra']['resolucion']))
            $model->resolucion = $param['Catedra']['resolucion'];

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'divisiones' => $divisiones,
            'propuestasall' => $propuestasall,
            'docentes' => $docentes,
            'resoluciones' => $resoluciones,
            'param' => $param,
        ]);
    }

    /**
     * Displays a single Catedra model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $origen = urldecode(Yii::$app->request->referrer);
        $existe = strpos($origen, 'catedra/index' );
        if ($existe > 0)
            Yii::$app->session->set('urlorigen', $origen.'#'.$id);
        
        $searchModel = new DetallecatedraSearch();
        $dataProvideractivo = $searchModel->providerxcatedra($id,Globales::DETCAT_ACTIVO);
        $dataProviderinactivo = $searchModel->providerxcatedra($id,Globales::DETCAT_ACTIVO);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modeldetalle' => Detallecatedra::find()->where([
                'catedra' => $id,
                
            ])->one(),
            'searchModel' => $searchModel,
            'dataProvideractivo' => $dataProvideractivo,
            'dataProviderinactivo' => $dataProviderinactivo,
            
        ]);
    }

    /**
     * Creates a new Catedra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Catedra();
        $modelpropuesta = new Propuesta();

        $actividades=Actividad::find()->all();
        $divisiones=Division::find()->all();
        $propuestas=Propuesta::find()->all();
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelpropuesta' => $modelpropuesta, 
            'actividades' => $actividades,
            'divisiones' => $divisiones,
            'propuestas' => $propuestas,
        ]);
    }

    /**
     * Updates an existing Catedra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelpropuesta = new Propuesta();
        
        $actividades=Actividad::find()->all();
        $divisiones=Division::find()->all();
        $propuestas=Propuesta::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'modelpropuesta' => $modelpropuesta,
            'actividades' => $actividades,
            'divisiones' => $divisiones,
            'propuestas' => $propuestas,
        ]);
    }

    /**
     * Deletes an existing Catedra model.
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
     * Finds the Catedra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Catedra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catedra::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
    
}
