<?php

namespace app\controllers;

use Yii;
use app\models\Division;
use app\models\DivisionSearch;
use app\models\Turno;
use app\models\Propuesta;
use app\models\Preceptoria;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\config\Globales;
use app\models\Docente;
use app\models\Nombramiento;
use yii\helpers\ArrayHelper;

/**
 * DivisionController implements the CRUD actions for Division model.
 */
class DivisionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'xpropuesta'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'xpropuesta'],   
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                try{
                                    return in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SECRETARIA]);
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
     * Lists all Division models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DivisionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Division model.
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
     * Creates a new Division model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Division();
        $turnos=Turno::find()->all();
        $propuestas=Propuesta::find()->all();
        $preceptorias=Preceptoria::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'turnos' => $turnos,
            'propuestas' => $propuestas,
            'preceptorias' => $preceptorias,
        ]);
    }

    /**
     * Updates an existing Division model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $turnos=Turno::find()->all();
        $propuestas=Propuesta::find()->all();
        $preceptorias=Preceptoria::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'turnos' => $turnos,
            'propuestas' => $propuestas,
            'preceptorias' => $preceptorias,
        ]);
    }

    /**
     * Deletes an existing Division model.
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
     * Finds the Division model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Division the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Division::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionXpropuesta()
    {   
        $searchModel = new DivisionSearch();
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $propuesta_id = $parents[0];
                $divisiones = Division::find()
                ->where(['propuesta' => $propuesta_id])
                ->orderBy('nombre ASC')
                ->all();
                

                $listDivisiones=ArrayHelper::toArray($divisiones, [
                    'app\models\Division' => [
                        'id',
                        'name' => 'nombre',
                    ],
                ]);
                $out = $listDivisiones;
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];
        
                
        
    }

    public function actionDivixprec($preceptoria)
    {   
        $searchModel = new DivisionSearch();
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                if(Yii::$app->user->identity->role == Globales::US_PRECEPTOR){
                    
                    $doc = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                    $nom = Nombramiento::find()
                                ->where(['docente' => $doc->id])
                                ->andWhere(['<=', 'division', 53])
                                ->all();
                    $array = [];
                    foreach ($nom as $n) {
                        $array [] = $n->division;
                    }
                        $divisiones=Division::find()
                        ->where(['preceptoria' => $preceptoria])
                        ->andWhere(['in', 'id', $array])
                        ->orderBy('nombre')->all();
                        
                }else{
                    $propuesta_id = $parents[0];
                    $divisiones = Division::find()
                        ->where(['preceptoria' => $preceptoria])
                        ->orderBy('nombre ASC')
                        ->all();
                }

                
                

                $listDivisiones=ArrayHelper::toArray($divisiones, [
                    'app\models\Division' => [
                        'id',
                        'name' => 'nombre',
                    ],
                ]);
                $out = $listDivisiones;
                return ['output'=>$out, 'selected'=>''];
            }

        }

        return ['output'=>'', 'selected'=>''];
        
                
        
    }
}
