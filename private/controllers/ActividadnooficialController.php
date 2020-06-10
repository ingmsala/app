<?php

namespace app\controllers;

use app\config\Globales;
use Yii;
use app\models\Actividadnooficial;
use app\models\ActividadnooficialSearch;
use app\models\Horariodj;
use kartik\form\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActividadnooficialController implements the CRUD actions for Actividadnooficial model.
 */
class ActividadnooficialController extends Controller
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
     * Lists all Actividadnooficial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActividadnooficialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Actividadnooficial model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $id,
        ]);
    }

    /**
     * Creates a new Actividadnooficial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($dj)
    {
        
        $model = Actividadnooficial::find()->where(['declaracionjurada' => $dj])->one();
        if($model == null){
            $model = new Actividadnooficial();
            $modelhorario = new Horariodj();
            $modelhorario->diasemana = 1;
        }else{
            try {
                $modelhorario = Horariodj::find()->where(['actividadnooficial' => $model->id])->one();
                $desdeexplode = explode("-",$model->ingreso);
                $newdatedesde = date("d/m/Y", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[2], $desdeexplode[0]));
                $model->ingreso = $newdatedesde;
                
            } catch (\Throwable $th) {
                $modelhorario = new Horariodj();
                $modelhorario->diasemana = 1;
                $modelhorario->actividadnooficial = $model->id;
            }
            
        }
        $model->declaracionjurada = $dj;
        
        
        if ($model->load(Yii::$app->request->post()) && $modelhorario->load(Yii::$app->request->post())) {
            if($modelhorario->validate()){

                $desdeexplode = explode("/",$model->ingreso);
                $newdatedesde = date("Y-m-d", mktime(0, 0, 0, $desdeexplode[1], $desdeexplode[0], $desdeexplode[2]));
                $model->ingreso = $newdatedesde;

                $model->save();
                $modelhorario->actividadnooficial = $model->id;
                $modelhorario->save();
                return $this->redirect(['declaracionjurada/percepciones']);
            }else{
                               
            }
            
        }

        

        return $this->renderAjax('create', [
            'model' => $model,
            'modelhorario' => $modelhorario,
            
        ]);
        

        
    }

    /**
     * Updates an existing Actividadnooficial model.
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
     * Deletes an existing Actividadnooficial model.
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
     * Finds the Actividadnooficial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Actividadnooficial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Actividadnooficial::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
