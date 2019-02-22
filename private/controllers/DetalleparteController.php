<?php

namespace app\controllers;

use Yii;
use app\models\Detalleparte;
use app\models\Parte;
use app\models\DetalleparteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Docente;
use app\models\Division;
use app\models\Hora;
use app\models\Falta;
use app\models\EstadoinasistenciaxparteSearch;
use app\models\Estadoinasistenciaxparte;


/**
 * DetalleparteController implements the CRUD actions for Detalleparte model.
 */
class DetalleparteController extends Controller
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
                        'actions' => ['create', 'update', 'delete'],   
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
                        'actions' => ['index', 'view'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->username, ['msala','secretaria']);
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
     * Lists all Detalleparte models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DetalleparteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Detalleparte model.
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
     * Creates a new Detalleparte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new Detalleparte();
        if (isset ($_REQUEST['parte'])) {
            $parte = $_REQUEST['parte'] ;
            
            $partex= Parte::findOne($parte);
            $divisiones=Division::find()
                ->where(['preceptoria' => $partex->preceptoria])
                ->orderBy('nombre')->all();
             

        }else{
                $parte='';
                $partex=Parte::find()->all();
                $divisiones=Division::find()->all();
        } 

        $docentes=Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $faltas = Falta::find()->all();
        $horas = Hora::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $ei = new EstadoinasistenciaxparteSearch();
            $model->estadoinasistencia = 1;
            if($model->save()){
                $guardaok = $ei->nuevo(null, 1, $model->id, $model->falta);
                if ($guardaok){
                   
                    return $this->redirect(['parte/view', 'id' => $parte]);
                }
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'docentes' => $docentes,
            'divisiones' => $divisiones,
            'partes' => $partex,
            'parte' => $parte,
            'horas' => $horas,
            'faltas' => $faltas,
        ]);
    }

    /**
     * Updates an existing Detalleparte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (isset ($_REQUEST['parte'])) {
            $parte = $_REQUEST['parte'] ;
            
            $partex= Parte::findOne($parte);
            $divisiones=Division::find()
                ->where(['preceptoria' => $partex->preceptoria])
                ->orderBy('nombre')->all();
             

        }else{
                $parte='';
                $partex=Parte::find()->all();
                $divisiones=Division::find()->all();
        } 

        $docentes=Docente::find()->orderBy('apellido', 'nombre', 'legajo')->all();
        $faltas = Falta::find()->all();
        $horas = Hora::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['parte/view', 'id' => $parte]);
        }
        if(Yii::$app->request->isAjax)
        return $this->renderAjax('update', [
            'model' => $model,
            'docentes' => $docentes,
            'divisiones' => $divisiones,
            'partes' => $partex,
            'parte' => $parte,
            'horas' => $horas,
            'faltas' => $faltas,
        ]);
    }

    /**
     * Deletes an existing Detalleparte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $parte = $model->parte;
        
        $ei = Estadoinasistenciaxparte::find()
            ->where(['detalleparte' => $id])->one();
        $ei->delete();
        $this->findModel($id)->delete();
        return $this->redirect(['parte/view', 'id' => $parte]);
    }

    /**
     * Finds the Detalleparte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Detalleparte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Detalleparte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
