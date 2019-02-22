<?php

namespace app\controllers;

use Yii;
use app\models\Parte;
use app\models\ParteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Detalleparte;
use app\models\Preceptoria;
use app\models\DetalleparteSearch;
use yii\filters\AccessControl;


/**
 * ParteController implements the CRUD actions for Parte model.
 */
class ParteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'controlregencia', 'controlsecretaria'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->username, ['msala', 'M2P','M1P','MPB','T2P','T1P','TPB','regenciatm', 'regenciatt', 'consulta']);
                                }catch(\Exception $exception){
                                    return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['create'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->username, ['msala', 'M2P','M1P','MPB','T2P','T1P','TPB']);
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
                                return in_array (Yii::$app->user->identity->username, ['msala']);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['controlregencia'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->username, ['msala', 'regenciatm', 'regenciatt']);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['controlsecretaria'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->username, ['msala', 'secretaria']);
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
     * Lists all Parte models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Parte model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->providerxparte($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modeldetalle' => Detalleparte::find()->where([
                'parte' => $id,
                
            ])->one(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Parte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (isset ($_POST['precepx'])) {
            $precepx = $_POST['precepx'];
            if(in_array (Yii::$app->user->identity->username, ["msala", "secretaria"])){
                $precepx=Preceptoria::find()
                    ->orderBy('nombre')->all();
            }else{
                $precepx=Preceptoria::find()
                    ->where(['nombre' => Yii::$app->user->identity->username])
                    ->orderBy('nombre')->all();
            }
            

        }
        $model = new Parte();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->fecha = Yii::$app->formatter->asDate($model->fecha, 'yyyy-MM-dd');

            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'precepx' => $precepx,
        ]);
        
        

        
    }

    /**
     * Updates an existing Parte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (isset ($_REQUEST['precepx'])) {
            $precepx = $_REQUEST['precepx'] ;
            $precepx=Preceptoria::find()
                ->where(['nombre' => $precepx])
                ->orderBy('nombre')->all();
        
        }else{
                
                $precepx=Preceptoria::find()->all();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'precepx' => $precepx,
        ]);
    }

    /**
     * Deletes an existing Parte model.
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

    public function actionControlregencia(){
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('controlregencia', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionControlsecretaria(){
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

        return $this->render('controlsecretaria', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Parte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Parte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Parte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
