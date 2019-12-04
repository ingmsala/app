<?php

namespace app\controllers;

use Yii;
use app\config\Globales;
use app\models\Actividadesmantenimiento;
use app\models\ActividadesmantenimientoSearch;
use app\models\Estadotarea;
use app\models\Tareamantenimiento;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ActividadesmantenimientoController implements the CRUD actions for Actividadesmantenimiento model.
 */
class ActividadesmantenimientoController extends Controller
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
                        'actions' => ['index', 'create'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_NOVEDADES,  Globales::US_MANTENIMIENTO]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['view', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
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
     * Lists all Actividadesmantenimiento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActividadesmantenimientoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Actividadesmantenimiento model.
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
     * Creates a new Actividadesmantenimiento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($tarea)
    {
        $model = new Actividadesmantenimiento();
        $modeltarea = Tareamantenimiento::findOne($tarea);
        $model->fecha = date('Y-m-d');
        $model->usuario = User::find()->where(['username' => Yii::$app->user->identity->username])->one()->id;
        $model->tareamantenimiento = $tarea;
        $estado = Estadotarea::find()->where(['in', 'id', [2,4]])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modeltarea->load(Yii::$app->request->post());
            if($modeltarea->estadotarea == 4){
                $modeltarea->fechafin = date('Y-m-d');
            }
            $modeltarea->save();

            return $this->redirect(['tareamantenimiento/view', 'id' => $tarea]);
        }
        if(Yii::$app->request->isAjax)
            return $this->renderAjax('create', [
                'model' => $model,
                'modeltarea' => $modeltarea,
                'estado' => $estado,
            ]);
        return $this->render('create', [
                'model' => $model,
                'modeltarea' => $modeltarea,
                'estado' => $estado,
            ]);
    }

    /**
     * Updates an existing Actividadesmantenimiento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Actividadesmantenimiento model.
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
     * Finds the Actividadesmantenimiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Actividadesmantenimiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Actividadesmantenimiento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
