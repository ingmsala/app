<?php

namespace app\controllers;

use app\config\Globales;
use Yii;
use app\models\Funciondj;
use app\models\FunciondjSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FunciondjController implements the CRUD actions for Funciondj model.
 */
class FunciondjController extends Controller
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
                        'actions' => ['index', 'view', ],   
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
                        'actions' => ['create', 'update', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_DOCENTE, Globales::US_NODOCENTE, Globales::US_PRECEPTOR, Globales::US_MANTENIMIENTO]);
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
     * Lists all Funciondj models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FunciondjSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Funciondj model.
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
     * Creates a new Funciondj model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($dj)
    {
        $model = new Funciondj();
        $model->scenario = Funciondj::SCENARIO_MOBILE;
        $model->declaracionjurada = $dj;
        $model->dependencia = 'UNC';
        $model->reparticion = 'Colegio Nacional de Monserrat';
        $model->publico = 1;
        $model->licencia = 1;
        
        $reparticiones = Funciondj::find()->all();
        
        if ($model->load(Yii::$app->request->post())) {
            if($model->publico == 2){
                $model->scenario = Funciondj::SCENARIO_MOBILE2;
                $model->dependencia = null;
            }
            $model->save();
            return $this->redirect(['declaracionjurada/cargos']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'reparticiones' => $reparticiones,
        ]);
    }

    /**
     * Updates an existing Funciondj model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Funciondj::SCENARIO_MOBILE;
        $reparticiones = Funciondj::find()->all();
        if($model->publico == 2){
            $model->dependencia = 'privada';
        }

        if ($model->load(Yii::$app->request->post())) {
            
            
            if($model->publico == 2){
                $model->scenario = Funciondj::SCENARIO_MOBILE2;
                $model->dependencia = null;
            }
            
            $model->save();
            
            
            return $this->redirect(['declaracionjurada/cargos']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'reparticiones' => $reparticiones,
        ]);
    }

    /**
     * Deletes an existing Funciondj model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['declaracionjurada/cargos']);
    }

    /**
     * Finds the Funciondj model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Funciondj the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Funciondj::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
