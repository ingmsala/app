<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\optativas\models\Calificacion;
use app\modules\optativas\models\CalificacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CalificacionController implements the CRUD actions for Calificacion model.
 */
class CalificacionController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,3,6,8,9,12,13,14]);
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
     * Lists all Calificacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if(false){
            $searchModel = new CalificacionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> La sección no está habilitada');
            return $this->redirect(['/optativas']);
        }
    }

    /**
     * Displays a single Calificacion model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if(false){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> La sección no está habilitada');
            return $this->redirect(['/optativas']);
        }
    }

    /**
     * Creates a new Calificacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'main';
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if(false){
        
            $model = new Calificacion();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> La sección de <b>Calificaciones</b> no está habilitada');
            return $this->redirect(['/optativas']);
        }
    }

    /**
     * Updates an existing Calificacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = 'main';
        $com = isset($_SESSION['comisionx']) ? $_SESSION['comisionx'] : 0;
        if(false){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
        Yii::$app->session->set('success', '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> La sección de <b>Calificaciones</b> no está habilitada');
            return $this->redirect(['/optativas']);
        }
    }

    /**
     * Deletes an existing Calificacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->layout = 'main';
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Calificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calificacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
