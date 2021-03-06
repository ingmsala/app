<?php

namespace app\controllers;

use Yii;
use app\config\Globales;
use app\models\Condicionnodocente;
use app\models\Genero;
use app\models\Nodocente;
use app\models\NodocenteSearch;
use app\models\User;
use kartik\grid\EditableColumnAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * NodocenteController implements the CRUD actions for Nodocente model.
 */
class NodocenteController extends Controller
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
                        'actions' => ['view', 'create', 'update'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_NOVEDADES, Globales::US_SECRETARIA, Globales::US_ABM_AGENTE]);
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
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER]);
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
                                return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_NOVEDADES, Globales::US_CONSULTA, Globales::US_DIRECCION, Globales::US_SECRETARIA, Globales::US_ABM_AGENTE]);
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

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editdocumento' => [                                       
                'class' => EditableColumnAction::className(),     
                'modelClass' => Nodocente::className(),                
                'outputValue' => function ($model, $attribute, $key, $index) {
                     //$fmt = Yii::$app->formatter;
                     return $model->$attribute;                 
                },
                'outputMessage' => function($model, $attribute, $key, $index) {
                      return '';                                  
                },
                
            ]
        ]);
    }

    /**
     * Lists all Nodocente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NodocenteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $planta = Nodocente::find()->where(['condicionnodocente' => 1])->count();
        $contratados = Nodocente::find()->where(['condicionnodocente' => 2])->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'planta' => $planta,
            'contratados' => $contratados,
        ]);
    }

    /**
     * Displays a single Nodocente model.
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
     * Creates a new Nodocente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Nodocente();
        
        $generos = Genero::find()->all();
        $condicion = Condicionnodocente::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->apellido = strtoupper($model->apellido);
            $model->nombre = strtoupper($model->nombre);
            $model->mail = strtolower($model->mail);
            $model->mapuche = 2;
            if($model->save()){
                $user = new User();
                $user->username = $model->mail;
                $user->role = Globales::US_AGENTE;
                $user->activate = 1;
                $user->setPassword($model->documento);
                $user->generateAuthKey();
                $user->save();
                Yii::$app->session->setFlash('success', "Se creó correctamente el registro");
                return $this->redirect(['index', 'id' => $model->id]);
            }
                
        }

        return $this->render('create', [
            'model' => $model,
            'generos' => $generos,
            'condicion' => $condicion,
        ]);
    }

    /**
     * Updates an existing Nodocente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $generos = Genero::find()->all();
        $condicion = Condicionnodocente::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $model->apellido = strtoupper($model->apellido);
            $model->nombre = strtoupper($model->nombre);
            $model->mail = strtolower($model->mail);
            if($model->save())
                Yii::$app->session->setFlash('success', "Se modificó correctamente el registro");
                return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'generos' => $generos,
            'condicion' => $condicion,
        ]);
    }

    /**
     * Deletes an existing Nodocente model.
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

    public function actionActualizarmapuche($id){
        $doc = $this->findModel($id);
        $doc->mapuche = 1;
        $doc->save();
        return $this->redirect(['/docente/actualizardomicilio']);
    }

    /**
     * Finds the Nodocente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nodocente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nodocente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
