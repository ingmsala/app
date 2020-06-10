<?php

namespace app\controllers;

use app\config\Globales;
use Yii;
use app\models\Pasividaddj;
use app\models\PasividaddjSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PasividaddjController implements the CRUD actions for Pasividaddj model.
 */
class PasividaddjController extends Controller
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
                        'actions' => ['index', 'view', 'update',],   
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
                        'actions' => ['create', 'delete'],   
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
     * Lists all Pasividaddj models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PasividaddjSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pasividaddj model.
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
     * Creates a new Pasividaddj model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($dj)
    {
        

        $model = Pasividaddj::find()->where(['declaracionjurada' => $dj])->one();
        if($model == null){
            $model = new Pasividaddj();
           
        }else{
            $desdeexplode = explode("-",$model->fecha);
            $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
            $model->fecha = $newdatedesde;
        }
        $model->declaracionjurada = $dj;
        $model->scenario = Pasividaddj::SCENARIO_DECLARACIONJURADA;

        if ($model->load(Yii::$app->request->post())) {
            $desdeexplode = explode("/",$model->fecha);
            $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
            $model->fecha = $newdatedesde;
            $model->save();
            return $this->redirect(['declaracionjurada/percepciones']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pasividaddj model.
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
     * Deletes an existing Pasividaddj model.
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
     * Finds the Pasividaddj model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pasividaddj the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pasividaddj::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
