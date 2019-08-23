<?php

namespace app\controllers;

use Yii;
use app\models\Avisoinasistencia;
use app\models\AvisoinasistenciaSearch;
use app\models\Docente;
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]);
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
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA, Globales::US_PRECEPTORIA]);
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
        $searchModel = new AvisoinasistenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $docentes = Docente::find()->orderBy('apellido, nombre')->all();

        if ($model->load(Yii::$app->request->post())) {
            
            $desdeexplode = explode("/",$model->desde);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            
            $hastaexplode = explode("/",$model->hasta);
            $newdatehasta = date("Y-m-d", mktime(0, 0, 0, $hastaexplode[1], $hastaexplode[0], $hastaexplode[2]));
            $model->desde = $newdatedesde;
            $model->hasta = $newdatehasta;
            //return $nuevafecha2;
            if ($model->save())
                return $this->redirect(['index']);
        }

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
        $docentes = Docente::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            
            $desdeexplode = explode("/",$model->desde);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            
            $hastaexplode = explode("/",$model->hasta);
            $newdatehasta = date("Y-m-d", mktime(0, 0, 0, $hastaexplode[1], $hastaexplode[0], $hastaexplode[2]));
            $model->desde = $newdatedesde;
            $model->hasta = $newdatehasta;
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
