<?php

namespace app\controllers;

use Yii;
use app\models\Preinscripcion;
use app\models\PreinscripcionSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PreinscripcionController implements the CRUD actions for Preinscripcion model.
 */
class PreinscripcionController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'delete'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1]);
                            }catch(\Exception $exception){
                                return false;
                            }
                        }

                    ],

                    [
                        'actions' => ['update'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            try{
                                return in_array (Yii::$app->user->identity->role, [1,4]);
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
     * Lists all Preinscripcion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PreinscripcionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Preinscripcion model.
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
     * Creates a new Preinscripcion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Preinscripcion();
        $tipodepublicacion=[
            0=> 'Inactivo',
            1=> 'Habilitado para inscripción',
            2=> 'Sólo Publicación',
            3=> 'Regido por fecha',

        ];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'tipodepublicacion' => $tipodepublicacion,
        ]);
    }

    /**
     * Updates an existing Preinscripcion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //date_default_timezone_set('America/Argentina/Buenos_Aires');

        

        if(Yii::$app->user->identity->role == 4 && $id != 1){
            Yii::$app->session->setFlash('error', "No tiene permisos para modificar el elemento");
            return $this->goHome();
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $model = $this->findModel($id);
        $model->inicio=Yii::$app->formatter->asDatetime($model->inicio, 'dd/MM/Y HH:mm');
        $model->fin=Yii::$app->formatter->asDatetime($model->fin, 'dd/MM/Y HH:mm');

        if(Yii::$app->user->identity->role == 4){
            $tipodepublicacion=[
                0=> 'Inactivo',
                3=> 'Habilitado según fechas',
            ];
        }else{
            $tipodepublicacion=[
                0=> 'Inactivo',
                1=> 'Habilitado para inscripción',
                2=> 'Sólo Publicación',
                3=> 'Regido por fecha',
            ];
        }
        

        if ($model->load(Yii::$app->request->post())) {
           /* $datatime = explode(" ",$model->inicio);
            $data = $datatime[0];
            $time = $datatime[1];
            $data = explode("-",$data);
            $data = date("Y-m-d", mktime(0, 0, 0, $data[1], $data[0], $data[2]));
            return $data;*/
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            
            $explode = explode(' ', $model->inicio);
            $date =   $explode[0];
            $date = explode('/',$date);
            $time = $explode[1];
            $date = $date[2].'-'.$date[1].'-'.$date[0];
            //$date = date("Y-m-d", mktime(0, 0, 0, $date[1], $date[0], $date[2]));
            $model->inicio=$date.' '.$time;
            //$model->fin=Yii::$app->formatter->asDatetime($model->fin);
            //date_default_timezone_set('America/Argentina/Buenos_Aires');
            $explode2 = explode(' ', $model->fin);
            $date2 =   $explode2[0];
            $date2 = explode('/',$date2);
            $time2 = $explode2[1];
            $date2 = $date2[2].'-'.$date2[1].'-'.$date2[0];
            //$date2 = date("Y-m-d", mktime(0, 0, 0, $date2[1], $date2[0], $date2[2]));
            $model->fin=$date2.' '.$time2;
            $model->save();
            Yii::$app->session->setFlash('success', "Se modificó correctamente la preinscripción");
                
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'tipodepublicacion' => $tipodepublicacion,
        ]);
    }

    /**
     * Deletes an existing Preinscripcion model.
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
     * Finds the Preinscripcion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Preinscripcion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Preinscripcion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
