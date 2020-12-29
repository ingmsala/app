<?php

namespace app\modules\optativas\controllers;

use Yii;
use app\modules\curriculares\models\Docentexcomision;
use app\modules\curriculares\models\Comision;
use app\models\Actividad;
use app\models\Role;
use app\models\Agente;
use app\modules\curriculares\models\DocentexcomisionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DocentexcomisionController implements the CRUD actions for Docentexcomision model.
 */
class DocentexcomisionController extends Controller
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
                                return in_array (Yii::$app->user->identity->role, [1]);
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
     * Lists all Docentexcomision models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $searchModel = new DocentexcomisionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docentexcomision model.
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
     * Creates a new Docentexcomision model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       

        $comisionx = Yii::$app->request->queryParams['id'];
        $model = new Docentexcomision();
        $docentes = Agente::find()
                    ->orderBy('apellido, nombre')
                    ->all();

        $comisiones = Comision::find()
                    ->where(['id' => $comisionx])
                    ->all();

        $optativa = Actividad::find()
                    ->joinWith(['espaciocurriculars', 'espaciocurriculars.comisions'])
                    ->where(['comision.id' => $comisionx])
                    ->all();

        $roles = Role::find()
                    ->where(['id' => 8])
                    ->orWhere(['id' => 9])
                    ->all();
        

        $model->comision = $comisionx;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/optativas/comision/view', 'id' => $comisionx]);
        }

        return $this->render('create', [
            'model' => $model,
            'docentes' => $docentes,
            'comisiones' => $comisiones,
            'optativa' => $optativa,
            'roles' => $roles,
            
        ]);
    }

    /**
     * Updates an existing Docentexcomision model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
       
        $model = $this->findModel($id);
        $comisionx = Yii::$app->request->queryParams['id'];
        
        $docentes = Agente::find()
                    ->orderBy('apellido, nombre')
                    ->all();

        $comisiones = Comision::find()
                    ->where(['id' => $comisionx])
                    ->all();

        $optativa = Actividad::find()
                    ->joinWith(['espaciocurriculars', 'espaciocurriculars.comisions'])
                    ->where(['comision.id' => $comisionx])
                    ->all();

        //$model->comision = $comisionx;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'docentes' => $docentes,
            'comisiones' => $comisiones,
            'optativa' => $optativa,
            
        ]);
    }

    /**
     * Deletes an existing Docentexcomision model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       
        $comision = $this->findModel($id)->comision;
        $this->findModel($id)->delete();
        
        return $this->redirect(['comision/view' , 'id' => $comision]);
    }

    /**
     * Finds the Docentexcomision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Docentexcomision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Docentexcomision::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
