<?php

namespace app\controllers;

use Yii;
use app\models\Avisoinasistencia;
use app\models\AvisoinasistenciaSearch;
use app\models\Agente;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;

/**
 * AvisoinasistenciaController implements the CRUD actions for Avisoinasistencia model.
 */
class AvisoinasistenciaController extends Controller
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
                        'actions' => ['view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_CONSULTORIO_MEDICO]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['index'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA, Globales::US_CONSULTORIO_MEDICO]);
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
     * Lists all Avisoinasistencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->identity->role == Globales::US_CONSULTORIO_MEDICO){
            $todos = 1;
        }else{
            $todos = 1;
        }
        $searchModel = new AvisoinasistenciaSearch();
        
        $dataProvider = $searchModel->search($todos);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Avisoinasistencia model.
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
     * Creates a new Avisoinasistencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Avisoinasistencia();
        $docentes = Agente::find()->orderBy('apellido, nombre')->all();

        if ($model->load(Yii::$app->request->post())) {

            if(Yii::$app->user->identity->role == Globales::US_REGENCIA){
                $model->tipoavisoparte = 1;
            }else{
                $model->tipoavisoparte = 2;
            }
            
            $desdeexplode = explode("/",$model->desde);

            if(count($desdeexplode) > 1){
                $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
                $model->desde = $newdatedesde;
            }else{
                $model->desde = null;
            }
            
            $hastaexplode = explode("/",$model->hasta);

            if(strpos($hastaexplode[2], "hasta") === false)
                $anio = $hastaexplode[2];
            else
                $anio = $hastaexplode[4];
            if(count($hastaexplode) > 1){
                $newdatehasta = date("Y-m-d", mktime(0, 0, 0, $hastaexplode[1], $hastaexplode[0], $anio));
                $model->hasta = $newdatehasta;
            }else{
                $model->hasta = null;
            }
            
            if ($model->save())
                return $this->redirect(['index']);
        }
        $model->desde = date("d/m/Y");
        $model->hasta = date("d/m/Y");
        return $this->render('create', [
            'model' => $model,
            'docentes' => $docentes,
        ]);
    }

    /**
     * Updates an existing Avisoinasistencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $docentes = Agente::find()->all();

            $desdeexplode1 = explode("-",$model->desde);
            
            if(count($desdeexplode1) > 1){
                $newdatedesde1 = date("d/m/Y", mktime(0, 0, 0, $desdeexplode1[1], $desdeexplode1[2], $desdeexplode1[0]));
                $model->desde = $newdatedesde1;
            }else{
                $model->desde = null;
            }

            $hastaexplode1 = explode("-",$model->hasta);

            if(count($hastaexplode1) > 1){
                $newdatehasta1 = date("d/m/Y", mktime(0, 0, 0, $hastaexplode1[1], $hastaexplode1[2], $hastaexplode1[0]));
                $model->hasta = $newdatehasta1;
            }else{
                $model->hasta = null;
            }

        if ($model->load(Yii::$app->request->post())) {
            
            $desdeexplode = explode("/",$model->desde);
            if(count($desdeexplode) > 1){
                $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
                $model->desde = $newdatedesde;
            }else{
                $model->desde = null;
            }

            $hastaexplode = explode("/",$model->hasta);
            if(strpos($hastaexplode[2], "hasta") === false)
                $anio = $hastaexplode[2];
            else
                $anio = $hastaexplode[4];
            if(count($hastaexplode) > 1){
                $newdatehasta = date("Y-m-d", mktime(0, 0, 0, $hastaexplode[1], $hastaexplode[0], $anio));
                $model->hasta = $newdatehasta;
            }else{
                $model->hasta = null;
            }
            //return $nuevafecha2;
            if ($model->save())
                return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'docentes' => $docentes,
        ]);
    }

    /**
     * Deletes an existing Avisoinasistencia model.
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
     * Finds the Avisoinasistencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Avisoinasistencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Avisoinasistencia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
