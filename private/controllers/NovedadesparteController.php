<?php

namespace app\controllers;

use Yii;
use app\models\Novedadesparte;
use app\models\Tiponovedad;
use app\models\Parte;
use app\models\Docente;
use app\models\NovedadesparteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;

/**
 * NovedadesparteController implements the CRUD actions for Novedadesparte model.
 */
class NovedadesparteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'panelnovedades', 'nuevoestado'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_PRECEPTORIA]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_PRECEPTORIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['nuevoestado'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['panelnovedades'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA, Globales::US_REGENCIA, Globales::US_CONSULTA]);
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
     * Lists all Novedadesparte models.
     * @return mixed
     */
    public function actionIndex($parte)
    {
        $searchModel = new NovedadesparteSearch();
        $dataProvider = $searchModel->novedadesxparte($parte);
        $model = Parte::findOne($parte);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Novedadesparte model.
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
     * Creates a new Novedadesparte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parte)
    {
        $model = new Novedadesparte();
        $model->estadonovedad = 1;
        $model->parte = $parte;

        $tiponovedades = Tiponovedad::find()->all();
        $preceptores = Docente::find()
                        ->orderBy('apellido, nombre')
                        ->all();


        if ($model->load(Yii::$app->request->post())) {
            if ($model->tiponovedad != 1 && $model->tiponovedad != 5){
                $model->docente = null;
            }

            if($model->save()){
                Yii::$app->session->setFlash('success', "Se guardó correctamente la novedad.");
                return $this->redirect(['/parte/view', 'id' => $model->parte]);
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'tiponovedades' => $tiponovedades,
            'preceptores' => $preceptores,
        ]);
    }

    /**
     * Updates an existing Novedadesparte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tiponovedades = Tiponovedad::find()->all();
        $preceptores = Docente::find()
                        ->orderBy('apellido, nombre')
                        ->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->tiponovedad != 1 && $model->tiponovedad != 5){
                $model->docente = null;
            }

            if($model->save()){
                Yii::$app->session->setFlash('success', "Se guardó correctamente la novedad.");
                return $this->redirect(['/parte/view', 'id' => $model->parte]);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'tiponovedades' => $tiponovedades,
            'preceptores' => $preceptores,
        ]);
    }

    /**
     * Deletes an existing Novedadesparte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $parte = $model->parte;
        $model->delete();
        Yii::$app->session->setFlash('success', "Se eliminó correctamente la novedad.");
        return $this->redirect(['/parte/view', 'id' => $parte]);
    }

    /**
     * Finds the Novedadesparte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Novedadesparte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Novedadesparte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionPanelnovedades()
    {
        $searchModel = new NovedadesparteSearch();
        $dataProvider = $searchModel->novedadesactivas();
        
        return $this->render('panelnovedades', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    public function actionNuevoestado($id)
    {
        $model = $this->findModel($id);
        $model->estadonovedad = 2;
        $model->save();

        $searchModel = new NovedadesparteSearch();
        $dataProvider = $searchModel->novedadesactivas();
        
        return $this->render('panelnovedades', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }
}
