<?php

namespace app\controllers;

use Yii;
use app\config\Globales;
use app\models\ActividadesmantenimientoSearch;
use app\models\Estadotarea;
use app\models\Nodocente;
use app\models\Novedadesparte;
use app\models\Prioridadtarea;
use app\models\Tareamantenimiento;
use app\models\TareamantenimientoSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TareamantenimientoController implements the CRUD actions for Tareamantenimiento model.
 */
class TareamantenimientoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'historial', 'recibir'],
                'rules' => [
                    
                    [
                        'actions' => ['create'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_MANTENIMIENTO, Globales::US_NOVEDADES]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['index', 'view', 'historial'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_MANTENIMIENTO, Globales::US_NOVEDADES, Globales::US_CONSULTA]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['recibir'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_MANTENIMIENTO]);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_NOVEDADES]);
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
     * Lists all Tareamantenimiento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TareamantenimientoSearch();
        $dataProvider = $searchModel->activos(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'historial' => false,
        ]);
    }

    public function actionHistorial()
    {
        $searchModel = new TareamantenimientoSearch();
        $dataProvider = $searchModel->realizados(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'historial' => true,
        ]);
    }
    /**
     * Displays a single Tareamantenimiento model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $actividadesSearch = new ActividadesmantenimientoSearch();

        $providerActividades = $actividadesSearch->actividadesxTarea($id);
        $estado = Estadotarea::find()->where(['in', 'id', [2,4]])->all();

        if(Yii::$app->request->isAjax)
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
                'providerActividades' => $providerActividades,
                'tarea' => $id,
                'estado' => $estado,
                'bm' => (Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO) ? false : true,
            ]);
        return $this->render('view', [
                'model' => $this->findModel($id),
                'providerActividades' => $providerActividades,
                'tarea' => $id,
                'estado' => $estado,
                'bm' => (Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO) ? false : true,
            ]);
    }

    /**
     * Creates a new Tareamantenimiento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($novedadesparte = "")
    {
        $descripcion = '';
        $novparte = '';
        if($novedadesparte != ""){
            $novedadesparte = Novedadesparte::findOne($novedadesparte);
            $descripcion = $novedadesparte->descripcion;
            $novparte = $novedadesparte->id;
        }
        
        $model = new Tareamantenimiento();
        $prioridad = Prioridadtarea::find()->all();
        if(Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO){
             $nodocentes= Nodocente::find()
                ->where(['legajo' => Yii::$app->user->identity->username])
                ->orderBy('apellido, nombre')
                ->all();
            
        }else{
             $nodocentes = Nodocente::find()->orderBy('apellido, nombre')->all();
        }
       
        $estado = Estadotarea::find()->all();
        $model->fecha = date('Y-m-d');
        $model->estadotarea = 1;
        $model->descripcion = $descripcion;
        $model->novedadparte = $novparte;
        //$usuario = User::select()->find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
                  if(Yii::$app->user->identity->role != Globales::US_MANTENIMIENTO){
                    if($model->responsable != null){

                        $responsable = Nodocente::findOne($model->responsable);
                        if($responsable->mail != null){
                            Yii::$app->mailer->compose()
                             ->setFrom(Globales::MAIL)
                             ->setTo($responsable->mail)
                             ->setSubject('Nueva asignación de tarea')
                             ->setHtmlBody('Se le ha asignado una nueva tarea de mantenimiento. Puede consultarla haciendo click '.Html::a('aquí', $url = 'http://admin.cnm.unc.edu.ar'))
                             ->send();
                        }
                        
                    }
                    
                }  
            
            
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if(Yii::$app->request->isAjax)
            return $this->renderAjax('create', [
                'model' => $model,
                'prioridad' => $prioridad,
                'estado' => $estado,
                'nodocentes' => $nodocentes,
            ]);
        else
            return $this->render('create', [
                'model' => $model,
                'prioridad' => $prioridad,
                'estado' => $estado,
                'nodocentes' => $nodocentes,
            ]);
    }

    /**
     * Updates an existing Tareamantenimiento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $prioridad = Prioridadtarea::find()->all();
        if(Yii::$app->user->identity->role == Globales::US_MANTENIMIENTO){
             $nodocentes= Nodocente::find()
                ->where(['legajo' => Yii::$app->user->identity->username])
                ->orderBy('apellido, nombre')
                ->all();
            
        }else{
             $nodocentes = Nodocente::find()->orderBy('apellido, nombre')->all();
        }
        $estado = Estadotarea::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'prioridad' => $prioridad,
            'estado' => $estado,
            'nodocentes' => $nodocentes,
        ]);
    }

    public function actionRecibir($id)
    {
        $model = $this->findModel($id);
        if($model->estadotarea == 1){
            $model->estadotarea = 2;
            $model->save();
        }
        
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Deletes an existing Tareamantenimiento model.
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
     * Finds the Tareamantenimiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tareamantenimiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tareamantenimiento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
